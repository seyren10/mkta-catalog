<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RecommendedProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function show(Product $product)
    {
        return RecommendedProduct::where('product_id', $product->id)->get();
    }
    public function destroy(RecommendedProduct $recommended)
    {
        $recommended->delete();
        return response()->noContent();
    }
}
