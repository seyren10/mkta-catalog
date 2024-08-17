<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAccessTypeRequest;
use App\Http\Resources\ProductAccessTypeResource;
use App\Models\ProductAccessType;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
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
    public function store(ProductAccessTypeRequest $request)
    {
        $product_access_type = ProductAccessType::create(array(
            "type" => strtolower($request->type),
            "title" => ucwords($request->title),
            "description" => ucfirst($request->description) ?? "",

            "ref_type" => strtolower($request->ref_type),
            "ref_table" => strtolower($request->ref_table),
            "ref_column" => strtolower($request->ref_column),
            "display_column" => strtolower($request->display_column),

            "source_table" => strtolower($request->source_table),
            "source_column" => strtolower($request->source_column),

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
        $product_access_type->type = ucwords($request->type) ?? $product_access_type->type;
        $product_access_type->title = ucwords($request->title) ?? $product_access_type->title;
        $product_access_type->description = ucfirst($request->description) ?? $product_access_type->description;

        $product_access_type->ref_type = ($request->ref_type) ?? $product_access_type->ref_type;
        $product_access_type->ref_table = ($request->ref_table) ?? $product_access_type->ref_table;
        $product_access_type->ref_column = ($request->ref_column) ?? $product_access_type->ref_column;
        $product_access_type->display_column = ($request->display_column) ?? $product_access_type->display_column;

        $product_access_type->source_table = ($request->source_table) ?? $product_access_type->source_table;
        $product_access_type->source_column = ($request->source_column) ?? $product_access_type->source_column;

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

    #region Custom Funciton for the Controllers
    public static function batchUpdate(Request $request)
    {
        foreach ($request->PAT_Changes as $key => $value) {
            $curPAT = ProductAccessType::where('id', $key)->first();
            if ( $curPAT === null ) {
                continue;
            }
            foreach ($value as $sourceData_ID => $SourceData_value) {
                #region Restricted
                if (array_key_exists('restricted', $SourceData_value)) {
                    if (array_key_exists('append', $SourceData_value['restricted'])) {
                        ProductRestriction::sync_product_restriction($curPAT->id, $sourceData_ID, $SourceData_value['restricted']['append']);
                    }
                    if (array_key_exists('remove', $SourceData_value['restricted'])) {
                        ProductRestriction::whereIn('product_id', $SourceData_value['restricted']['remove'])
                            ->where('product_access_type_id', $curPAT->id)
                            ->where('value', $sourceData_ID)
                            ->delete();
                    }
                }
                #endregion
                #region Exempted
                if (array_key_exists('exempted', $SourceData_value)) {
                    if (array_key_exists('append', $SourceData_value['exempted'])) {
                        ProductExemption::sync_product_exemption($curPAT->id, $sourceData_ID, $SourceData_value['exempted']['append']);
                    }
                    if (array_key_exists('remove', $SourceData_value['exempted'])) {
                        ProductExemption::whereIn('product_id', $SourceData_value['exempted']['remove'])
                            ->where('product_access_type_id', $curPAT->id)
                            ->where('value', $sourceData_ID)
                            ->delete();
                    }
                }
                #endregion
            }

        }
        return response()->noContent(200);
    }
    #endregion

}
