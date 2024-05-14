<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductAccessTypeResource;
use App\Models\ProductAccessType;
use Illuminate\Http\Request;

class ProductAccessTypeController extends Controller
{
    #region Default Function for Controllers
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductAccessTypeResource::collection(ProductAccessType::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */ 
    public function store(Request $request)
    {
        $product_access_type = ProductAccessType::create(array(
            "type" => strtolower($request->type),
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",
        ));
        return response()->json(['message' => 'Product Access Type created successfully', 'product_access_type' => $product_access_type], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductAccessType $product_access_type)
    {
        return new ProductAccessTypeResource($product_access_type);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductAccessType $product_access_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductAccessType $product_access_type)
    {
        $product_access_type->type =ucwords($request->key) ?? $product_access_type->type;
        $product_access_type->title =ucwords($request->title) ?? $product_access_type->title;
        $product_access_type->description = ucfirst($request->description) ??  $product_access_type->description;
        $product_access_type->save();
        return response()->json(['message' => 'Product Access Type updated successfully', 'permission' => $product_access_type], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAccessType $product_access_type)
    {
        $product_access_type->delete();
        return response()->json(['message' => 'Product Access Type deleted successfully'], 200);
    }
    #endregion
}
