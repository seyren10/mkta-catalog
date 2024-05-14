<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductAccessTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        #region Source Data
        if( $request->has('includeSourceData') ){
            if($request->includeSourceData === 'true' || $request->includeSourceData === true){
                $data['source_data'] = DB::table($data['source_table'])->select(['id', $data['source_column']])->get();
            }
        }
        #endregion
        #region Other Data
        $removeOtherData = true;
        if( $request->has('includeOtherData') ){
            if($request->includeOtherData === 'true' || $request->includeOtherData === true){
                $removeOtherData = !true;
            }
        }
        if($removeOtherData){
            foreach ([
                    "type",
                    "ref_type", 
                    "ref_table", 
                    "ref_column", 
                    "source_table", 
                    "source_column"
                ] as $value) {
                unset($data[$value]);
            }
        }
        #endregion
        return $data;
    }
}
