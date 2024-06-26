<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductAccessResource;
use App\Models\Product;
use App\Models\ProductAccessType;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductAccessController extends Controller
{
    public function show(ProductAccessType $product_access)
    {
        return new ProductAccessResource($product_access);
    }

    public function modify_ProductAccess($action_type, Product $product, ProductAccessType $product_access, $value, Request $request)
    {
        try {
            DB::beginTransaction();
            #region Exemption
            if ($action_type == 'exemption') {
                if ($request->getMethod() === 'POST') {
                    ProductExemption::create(array(
                        "product_id" => $product->id,
                        "product_access_type_id" => $product_access->id,
                        "value" => $value,
                    ));
                }
                if ($request->getMethod() === 'DELETE') {
                    ProductExemption::where('product_id', $product->id)
                        ->where('product_access_type_id', $product_access->id)
                        ->where('value', $value)
                        ->delete();
                }
            }
            #endregion
            #region Restriction
            if ($action_type == 'restriction') {
                if ($request->getMethod() === 'POST') {
                    ProductRestriction::create(array(
                        "product_id" => $product->id,
                        "product_access_type_id" => $product_access->id,
                        "value" => $value,
                    ));
                }
                if ($request->getMethod() === 'DELETE') {
                    ProductRestriction::where('product_id', $product->id)
                        ->where('product_access_type_id', $product_access->id)
                        ->where('value', $value)
                        ->delete();
                }
            }
            #endregion
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        } finally {
            return response()->json(['message' => 'success'], 200);
        }
    }
}
