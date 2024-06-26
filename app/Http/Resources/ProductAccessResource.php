<?php

namespace App\Http\Resources;

use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductAccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        #region Source Data
        if ($request->has('includeSourceData')) {
            if ($request->includeSourceData === 'true' || $request->includeSourceData === true) {
                $data['source_data'] = DB::table($data['source_table'])->select(['id', $data['source_column']])->get();
            }
        }
        #endregion
        #region Restricted Data
        if ($request->has('includeRestrictedData')) {
            if ($request->includeRestrictedData === 'true' || $request->includeRestrictedData === true) {
                $restricte_id = ProductRestriction::where('product_access_type_id', $data['id'])->where('product_id', $request->product_id)->get()->pluck('value');
                $data['restricted_data'] = DB::table($data['source_table'])->whereIn('id', $restricte_id)->select('id', $data['source_column'])->get();
                // $data['restricted_data'] = ProductRestriction::where('product_access_type_id', $data['id'])->get()->pluck('value');
            }
        }
        #endregion
        #region Exempted Data
        if ($request->has('includeExemptedData')) {
            if ($request->includeExemptedData === 'true' || $request->includeExemptedData === true) {
                $exempted_id = ProductExemption::where('product_access_type_id', $data['id'])->where('product_id', $request->product_id)->get()->pluck('value');
                $data['exempted_data'] =  DB::table($data['source_table'])->whereIn('id', $exempted_id)->select('id', $data['source_column'])->get();
            }
        }
        #endregion
        foreach ([
            // "ref_type",
            // "ref_table",
            // "ref_column",
            // "display_column",
            // "source_table",
            // "source_column",
        ] as $value) {
            unset($data[$value]);
        }
        return $data;
    }
}
