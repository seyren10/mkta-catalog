<?php

namespace App\Http\Resources;

use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ProductAccessTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        
        $data = parent::toArray($request);
        #region Source Data
        if ($request->has('includeSourceData')) {
            if ($request->includeSourceData === 'true' || $request->includeSourceData === true) {
                $sourceData = DB::table($data['source_table'])
                    ->select(['id', $data['source_column']])
                    ->get();
                
                if ($request->has('includeSourceDataProducts')) {
                    if ($request->includeSourceDataProducts === 'true' || $request->includeSourceDataProducts === true) {
                        $sourceData = $sourceData->map(function ($item) use ($data) {
                            // Add a new 'restricted' key with an empty array to each item
                            $item->restricted = collect(ProductRestriction::where('product_access_type_id', $data['id'])->where('value', $item->id)->with(['product_data'])->get())->pluck('product_data');
                            $item->exempted = collect(ProductExemption::where('product_access_type_id', $data['id'])->where('value', $item->id)->with(['product_data'])->get())->pluck('product_data');

                            return $item;
                        });
                    }

                }
                $tempData = [];
                $tempData['id'] = 0;
                $tempData[$data['source_column']] = 'All';

                $sourceData = array_merge( $tempData, $sourceData->toArray());
                // $data['source_data'] = $sourceData;
            }
        }
        $data['fuck'] = 'fuck';
        #endregion
        #region Other Data
        $removeOtherData = true;
        if ($request->has('includeOtherData')) {
            if ($request->includeOtherData === 'true' || $request->includeOtherData === true) {
                $removeOtherData = !true;
            }
        }
        if ($removeOtherData) {
            foreach ([
                "ref_type",
                "ref_table",
                "ref_column",
                "source_table",
                "source_column",
            ] as $value) {
                unset($data[$value]);
            }
        }
        #endregion
        return $data;
    }
}
