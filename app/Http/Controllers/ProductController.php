<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->q;

        if ($query) {
            $searchedProducts = Product::whereAny([
                'id', 'title', 'description'
            ], 'LIKE', '%' . $query . '%')->paginate(30);

            return ProductResource::collection($searchedProducts);
        }

        return ProductResource::collection(Product::paginate(30));
    }
    public function getProductsWithCategoryId(Category $category)
    {

        return  ProductResource::collection(Product::whereHas('product_categories', function ($query) use ($category) {
            if ($category->id) {
                $query->where('product_categories.category_id', $category->id);
            }
        })->paginate(32)->withQueryString());
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
                    "message" => "Categories Updated"
                ), 200);
            }
            return response(array(
                "message" => "No Categories included"
            ), 200);
        } catch (\Throwable $th) {
            return response(array(
                "message" => $th->getMessage()
            ), 422);
            DB::rollback();
        }
    }
    #endregion

}
