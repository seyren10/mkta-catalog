<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductComponentRequest;
use App\Models\Product;
use App\Models\ProductComponent;
use Illuminate\Http\Request;

class ProductComponentController extends Controller
{
    public static function createProductComponents(ProductComponentRequest $request, Product $product){

    }
    public static function showProductComponents( ProductComponentRequest $request,Product $product){
        
    }
    public function store(Request $request, Product $product)
    {
        ProductComponent::create(
            array(
                "type" => $request->type,
                "is_visible" => $request->is_visible ?? false,
                "index" => $request->index ?? 100,
                "title" => $request->title,
                "value" => $request->value,
                "product_id" => $product->id,
            )
        );
        return response()->json(["message" => "Components have been added to ".$product->id], 200);
    }
    public function update(Request $request, ProductComponent $product_component)
    {
        $product_component->save();
        return response()->json(["message" => "Components have been updated."], 200);

    }
    public function destroy(ProductComponent $product_component)
    {
        $product_component->delete();
        return response()->json(["message" => "Components have been removed."], 200);
        
    }
}
