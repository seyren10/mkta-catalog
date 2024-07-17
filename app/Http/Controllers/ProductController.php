<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFilter;
use Illuminate\Http\Request;
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

        /* Searching products */
        $query = $request->q;
        if ($query) {
            $searchedProducts = Product::whereAny([
                'id', 'title', 'description',
            ], 'LIKE', '%' . $query . '%')->whereNotIn('id', $restricted_products)->paginate(30)->withQueryString();

            return ProductResource::collection($searchedProducts);
        }

        return ProductResource::collection(Product::whereNotIn('id', $restricted_products)->paginate(30)->withQueryString());
    }

    public function getProductsWithCategoryId(Request $request, Category $category)
    {
        $query = Product::whereHas('product_categories', function ($query) use ($category) {
            if ($category->id) {
                $query->where('product_categories.category_id', $category->id);
            }
        });

        if ($request->has('filters')) {
            $query->whereHas('productFilters', function ($query) use ($request) {
                $filterTitles = Filter::all()->pluck('title')->toArray();


                $choiceIds = collect();
                foreach ($request->filters as $key => $value) {
                    if (in_array($key, $filterTitles)) {
                        $choiceIds->push(...explode(',', $value));
                    }
                }
                Log::info($choiceIds);
                $query->whereIn('filter_choice_id', $choiceIds);
            });
        }

        $restricted_products = $request->session()->get('restricted_products', array());
        $query->whereNotIn('id', $restricted_products);

        return ProductResource::collection($query->paginate(32)->withQueryString());
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
    public function show(Product $product)
    {
        return new ProductResource($product);
    }
    public function update(ProductRequest $request, Product $product)
    {
        foreach ($request->all() as $key => $value) {
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
    #endregion

}
