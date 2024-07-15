<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RecommendedProduct;
use Illuminate\Http\Request;

class RecommendedProductController extends Controller
{
    public function store(Product $product, Product $recommendedProduct)
    {

        RecommendedProduct::create(
            array(
                'product_id' => $product->id,
                'recommended_product_id' => $recommendedProduct->id,
            )
        );
        return response()->noContent();
    }
    public function show(Product $product, Request $request)
    {
        $restricted_products = $request->session()->get('restricted_products', array());
        return RecommendedProduct::whereNotIn('id',$restricted_products)->where('product_id', $product->id)->get();
    }
    public function destroy(RecommendedProduct $recommended)
    {
        $recommended->delete();
        return response()->noContent();
    }
}
