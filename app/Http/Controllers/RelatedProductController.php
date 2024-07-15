<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RelatedProduct;
use Illuminate\Http\Request;

class RelatedProductController extends Controller
{
    public function store(Product $product, Product $relatedProduct)
    {
        RelatedProduct::create(
            array(
                'product_id' => $product->id,
                'related_product_id' => $relatedProduct->id,
            )
        );
        return response()->noContent();
    }
    public function show(Product $product, Request $request)
    {
        $restricted_products = $request->session()->get('restricted_products', array());

        return RelatedProduct::whereNotIn('id',$restricted_products)->where('product_id', $product->id)->get();
    }
    public function destroy(RelatedProduct $related)
    {
        $related->delete();
        return response()->noContent();
    }
}
