<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductComponentResource;
use App\Models\Product;
use App\Models\ProductComponent;
use Illuminate\Http\Request;

class ProductComponentController extends Controller
{
    public static function createProductComponents(Request $request, Product $product)
    {
        ProductComponent::create(
            array(
                "type" => $request->type,
                "is_visible" => $request->is_visible ? 1 : 0,
                "index" => $request->index ?? 100,
                "title" => $request->title,
                "value" => $request->value,
                "product_id" => $product->id,
            )
        );
        return response()->json(["message" => "Components have been added to " . $product->id], 200);
    }
    public static function showProductComponents(Product $product)
    {
        return ProductComponentResource::collection(ProductComponent::where('product_id', $product->id)->orderBy('index', 'ASC')->get());
    }
    public function update(Request $request, ProductComponent $product_component)
    {
        $product_component->type = $request->type ?? $product_component->type;
        $product_component->is_visible = $request->is_visible ?? $product_component->is_visible;
        $product_component->index = $request->index ?? $product_component->index;
        $product_component->title = $request->title ?? $product_component->title;
        $product_component->value = $request->value ?? $product_component->value;
        $product_component->save();
        return response()->json(["message" => "Components have been updated."], 200);

    }
    public function destroy(ProductComponent $product_component)
    {
        $product_component->delete();
        return response()->json(["message" => "Components have been removed."], 200);

    }
}
