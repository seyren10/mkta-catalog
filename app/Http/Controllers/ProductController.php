<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::get());
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
        foreach ($request['data'] as $key => $value) {
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
    

}
