<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\RelatedProduct;

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
    public function show(Product $product)
    {
        return RelatedProduct::where('product_id', $product->id)->get();
    }
    public function destroy(RelatedProduct $related)
    {
        $related->delete();
        return response()->noContent();
    }
}
