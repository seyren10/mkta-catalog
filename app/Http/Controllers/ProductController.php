<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductVerificationRequest;
use App\Http\Resources\ProductResource;

use App\Http\Requests\DirectUploadImageRequest;

use App\Jobs\ZipProductImages;

use App\Models\Category;
use App\Models\Filter;
use App\Models\NewProductNotfication;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductExemption;
use App\Models\ProductImage;
use App\Models\ProductRestriction;
use App\Models\RecommendedProduct;
use App\Models\RelatedProduct;
use App\Models\Season;
use App\Models\TempImageUpload;

use App\Services\BCProductService;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $restricted_products = $request->session()->get('restricted_products', array());
        $products = Product::whereNotIn('id', $restricted_products);

        /* Searching products */
        $query = $request->q;
        $perPage = $request->perPage ?? 30;

        if ($request->has('unlisted')) {
            $products->whereNotIn('id', $request->unlisted);
        }

        if ($query) {
            $searchedProducts = $products->whereAny([
                'id',
                'title',
                'description',
            ], 'LIKE', '%' . $query . '%')->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

            return ProductResource::collection($searchedProducts);
        }

        return ProductResource::collection($products->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString());
    }

    /*
    Display a listing of resource and add it to the cache
    this is to make the retrieval faster on subsequent request
     */
    public function indexCached()
    {
        $time = now()->addHour(); //validity of the cache

        if (request()->has('refresh')) {
            Cache::store('file')->forget('products');
        }

        $products = Cache::store('file')->remember('products', $time, function () {
            return Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->select('id', 'title')->get();
        });

        return ProductResource::collection($products);
    }
    public function latestProducts(Request $request)
    {
        $count = $request->has('count') ? $request->count : 20;
        return ProductResource::collection(Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->latest()->take($count)->get());
    }
    public function seasonProducts(Request $request)
    {
        $current = Carbon::now();
        $inSeason = collect(Season::get())
            ->filter(function ($season) use ($current) {
                return $current->between(
                    Carbon::parse($season->actual_start_date)
                    ,
                    Carbon::parse($season->actual_end_date)
                );
            })
            ->map(function ($season) {
                return $season->categories->map(function ($cur) {
                    return $cur->category_id;
                });
            })
            ->flatten()
            ->unique();

        $restricted_products = $request->session()->get('restricted_products', []);
        // $restricted_products = [];
        #region Preparation for Products
        // Get categories with a single query that checks both 'id' and 'parent_id' conditions
        $categoryPool = Category::whereIn('id', $inSeason)
            ->orWhereIn('parent_id', $inSeason)
            ->pluck('id')
            ->toArray(); // convert to array for use in whereIn query

        // Get product IDs directly through a join between ProductCategory and Category
        $productPool = ProductCategory::whereIn('category_id', $categoryPool)
            ->pluck('product_id')
            ->toArray();

        // Fetch products, apply restriction, and order them randomly in one query
        $products = Product::whereIn('id', $productPool)
            ->whereNotIn('id', $restricted_products)
            ->limit(30)
            ->get();

        // Return the response with optimized data
        return response()->json(
            [
                'title' => 'On Season',
                // 'data' => $products,
                'data' => ProductResource::collection($products),
            ],
            200
        );
        #endregion
    }

    public function randomProducts(Request $request)
    {
        $count = $request->has('count') ? $request->count : 20;

        return ProductResource::collection(
            Product::whereNotIn(
                'id',
                $request->session()->get('restricted_products', array())
            )
                ->inRandomOrder()
                ->take($count)->get());
    }

    public function getProductsWithCategoryId(Request $request, Category $category)
    {
        $query = Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->whereHas('product_categories', function ($query) use ($category) {
            if ($category->id) {
                $query->where('product_categories.category_id', $category->id);
            }
        });

        $search = $request->q;
        $perPage = $request->perPage ?? 32;

        if ($search) {
            $query->whereAny([
                'id',
                'title',
                'description',
            ], 'LIKE', '%' . $search . '%');
        }

        /* filtering */
        if ($request->has('filters')) {
            $query->whereHas('productFilters', function ($query) use ($request) {
                $filterTitles = Filter::all()->pluck('title')->toArray();
                $choiceIds = collect();
                foreach ($request->filters as $key => $value) {
                    if (in_array($key, $filterTitles)) {
                        $choiceIds->push(...explode(',', $value));
                    }
                }
                $query->whereIn('filter_choice_id', $choiceIds);
            });
        }

        /* sorting */
        if ($request->has('sortBy')) {
            if ($request->sortBy === 'any-order') {
                $query->inRandomOrder();
            } else if ($request->sortBy === 'newest-first') {
                $query->orderByDesc('created_at');
            }
        }
        if ($request->has('sub')) {
            $query->whereIn('id', ProductCategory::where('category_id', $request->sub)->pluck('product_id'));
        }

        $restricted_products = $request->session()->get('restricted_products', array());
        $query->whereNotIn('id', $restricted_products);

        return ProductResource::collection($query->paginate($perPage)->withQueryString());
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create(
            array(
                "id" => $request->id,
                "parent_code" => $request->paren_code,
                "title" => $request->title,
                "description" => $request->description,
                "volume" => $request->volume,
                "weight_net" => $request->weight_net,
                "weight_gross" => $request->weight_gross,
                "dimension_length" => $request->dimension_length,
                "dimension_width" => $request->dimension_width,
                "dimension_height" => $request->dimension_height,
            )
        );
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 200);
    }
    public function show(Request $request, Product $product)
    {
        $restricted_products = $request->session()->get('restricted_products', array());
        if (in_array($product->id, $restricted_products)) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return new ProductResource($product);
    }
    public function update(ProductRequest $request, Product $product)
    {
        foreach ($request->all() as $key => $value) {
            if (!in_array($key, [
                "id",
                "parent_code",
                "title",
                "description",
                "volume",
                "weight_net",
                "weight_gross",
                "dimension_length",
                "dimension_width",
                "dimension_height",
            ])) {
                continue;
            }
            $product[$key] = $value;
        }
        $product->save();
        return response()->json(['message' => 'Product updated successfully'], 200);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
    #endregion

    #region Custom Function for Product Controller
    public static function modifyProductCategories(Product $product, Request $request)
    {
        try {
            DB::beginTransaction();
            ProductCategory::where('product_id', $product->id)->delete();
            if ($request->has('categories')) {
                foreach ($request->categories as $key => $value) {
                    ProductCategory::create(
                        array(
                            "product_id" => $product->id,
                            "category_id" => $value,
                        )
                    );
                }
                DB::commit();
                return response(array(
                    "message" => "Categories Updated",
                ), 200);
            }
            return response(array(
                "message" => "No Categories included",
            ), 200);
        } catch (\Throwable $th) {
            return response(array(
                "message" => $th->getMessage(),
            ), 422);
            DB::rollback();
        }
    }
    public static function zipProductImages(Product $product)
    {
        dispatch(new ZipProductImages($product->id, Auth()->user()->id));
        return response()->noContent();
    }
    public static function batchUpdate(Request $request)
    {
        foreach ($request->products as $key => $value) {
            $curProduct = Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->where('id', $key)->with([])->first();
            #region Data Structure Validation
            $allowContinue = [
                !($curProduct === null),
                array_key_exists('prod_data', $value),
                array_key_exists('cat_data', $value),
                array_key_exists('related', $value),
                array_key_exists('recommended', $value),
            ];
            if (in_array(false, $allowContinue)) {
                continue;
            }
            $allowContinue = [
                array_key_exists('append', $value['related']),
                array_key_exists('remove', $value['related']),
                array_key_exists('append', $value['recommended']),
                array_key_exists('remove', $value['recommended']),
            ];
            if (in_array(false, $allowContinue)) {
                continue;
            }
            #endregion

            #region Product Info Update
            foreach ($value['prod_data'] as $col => $data) {
                $curProduct[$col] = $data;
            }
            $curProduct->save();
            #endregion
            #region Product Categories
            // ProductCategory::where('product_id', $key)->delete();
            // Remove the value 0
            $array = $value['cat_data'];
            $valueToRemove = 0;
            $key = array_search($valueToRemove, $array);

            if ($key !== false) {
                unset($array[$key]);
            }
            $array = array_values($array);
            $curProduct->sync_product_categories()->sync($array);
            #endregion
            #region Product Related
            $linkProducts = $value['related'];
            #region Append
            foreach ($linkProducts['append'] as $appendValue) {
                RelatedProduct::create(
                    array(
                        'product_id' => $curProduct->id,
                        'related_product_id' => $appendValue,
                    )
                );
            }
            #endregion
            #region Remove
            RelatedProduct::whereIn('related_product_id', $linkProducts['remove'])->delete();
            #endregion
            #endregion
            #region Product Recommended
            $linkProducts = $value['recommended'];
            #region Append
            foreach ($linkProducts['append'] as $appendValue) {
                RecommendedProduct::create(
                    array(
                        'product_id' => $curProduct->id,
                        'recommended_product_id' => $appendValue,
                    )
                );
            }
            #endregion
            #region Remove

            RecommendedProduct::whereIn('recommended_product_id', $linkProducts['remove'])->delete();
            #endregion
            #endregion

        }
        return response()->noContent(200);
    }
    #endregion

    public function bcProductDetails(Request $request)
    {
        try {
            $product_notification = NewProductNotfication::where("token", $request->token)->first();

            if ($product_notification && !$product_notification->processed_at) {
                $product_service = new BCProductService;
                $product = $product_service->get_product($request->token);

                if ($product) {
                    return response()->json([
                        "data" => $product,
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Product not found',
                        'status' => 404,
                    ], 404);
                }
            } else {
                return response()->json([
                    'message' => 'Token expired',
                    'status' => 404,
                ], 404);
            }
        } catch (\Throwable $e) {
            \Log::error($e);
            $message = "Error: " . $e->getMessage();

            return response()->json([
                "message" => $message,
            ], 400);
        }
    }

    public function storeProductVerification(ProductVerificationRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has("info")) {
                // Product Basic Info
                $product_request = (object) $request->info;

                // Set Product Basic Info
                $product = new Product;
                $product->id = $product_request->product_id;
                $product->parent_code = $product_request->parent_code;
                $product->title = $product_request->title;
                $product->description = $product_request->description;
                $product->volume = $product_request->volume;
                $product->weight_net = $product_request->weight_net;
                $product->weight_gross = $product_request->weight_gross;
                $product->dimension_length = $product_request->dimension_length;
                $product->dimension_width = $product_request->dimension_width;
                $product->dimension_height = $product_request->dimension_height;
                $product->save();

                // Set Product Category upon detection
                ProductCategory::where('product_id', $product->id)->delete();
                if ($request->has('category')) {
                    $categories = $request->category;

                    foreach ($categories as $key => $value) {
                        ProductCategory::create(
                            array(
                                "product_id" => $product->id,
                                "category_id" => $value,
                            )
                        );
                    }
                }

                // Set Product Image
                if ($request->has("images")) {
                    $count = ProductImage::where('product_id')->get()->count() + 1;
                    $product_images = $request->images;

                    foreach ($product_images as $product_image_array) {
                        $product_image = (object) $product_image_array;

                        ProductImage::create(
                            array(
                                "product_id" => $product->id,
                                "is_thumbnail" => true,
                                "file_id" => $product_image->id,
                                "index" => $count,
                            )
                        );

                        $count += 1;
                    }
                }

                // Set Product Restriction and Excemption
                if ($request->has('restrictionAndExcemption')) {
                    $restriction_excemptions = $request->restrictionAndExcemption;

                    foreach ($restriction_excemptions as $product_access_type => $restriction_excemption_array) {
                        foreach ($restriction_excemption_array as $index => $restriction_excemption) {
                            if ($index == "restricted") {
                                foreach ($restriction_excemption as $restricted_array) {
                                    $restricted = (object) $restricted_array;

                                    ProductRestriction::create(array(
                                        "product_id" => $product->id,
                                        "product_access_type_id" => $product_access_type,
                                        "value" => $restricted->id,
                                    ));
                                }
                            } else {
                                foreach ($restriction_excemption as $excempted_array) {
                                    $excempted = (object) $excempted_array;

                                    ProductExemption::create(array(
                                        "product_id" => $product->id,
                                        "product_access_type_id" => $product_access_type,
                                        "value" => $excempted->id,
                                    ));
                                }
                            }
                        }
                    }
                }

                // Set Related Products
                if ($request->has("related")) {
                    $relateds = $request->related;

                    foreach ($relateds as $related_array) {
                        $related = (object) $related_array;
                        RelatedProduct::create(
                            array(
                                'product_id' => $product->id,
                                'related_product_id' => $related->id,
                            )
                        );
                    }
                }

                // Set Recommended Productss
                if ($request->has("recommended")) {
                    $recommendeds = $request->recommended;

                    foreach ($recommendeds as $recommended_array) {
                        $recommended = (object) $recommended_array;

                        RecommendedProduct::create(
                            array(
                                'product_id' => $product->id,
                                'recommended_product_id' => $recommended->id,
                            )
                        );
                    }
                }
            }

            $product_notification = NewProductNotfication::where("token", $request->token)->first();
            $product_notification->processed_at = Carbon::now();
            $product_notification->save();

            DB::commit();

            return response()->json([
                "message" => "Product details has been successfully saved!",
            ], 200);
        } catch (\Throwable $e) {
            \Log::error($e);
            $message = "Error: " . $e->getMessage();

            DB::rollback();

            return response()->json([
                "message" => $message,
            ], 400);
        }
    }

    public function directUploadImage($sku, DirectUploadImageRequest $request){
        try{
            $existing = TempImageUpload::where("sku", $sku)->first();

            if($existing){
                $temp_upload = $existing;
            }else{
                $temp_upload = new TempImageUpload;
            }

            $temp_upload->data = json_encode($request->images);
            $temp_upload->sku = $sku;
            $temp_upload->save();

            return response()->json([
                "message" => "Successfully saved images"
            ], 200);
        }catch(\Throwable $e){
            \Log::error($e);
            $message = "Error: " . $e->getMessage();

            DB::rollback();

            return response()->json([
                "message" => $message,
            ], 400);
        }
    }

    public function getDirectUploadImage($sku){
        try{
            $temp_upload = TempImageUpload::where('sku', $sku)->first();

            return response()->json([
                "data" => $temp_upload
            ], 200);
        }catch(\Throwable $e){
            \Log::error($e);
            $message = "Error: " . $e->getMessage();

            DB::rollback();

            return response()->json([
                "message" => $message,
            ], 400);
        }
    }
}
