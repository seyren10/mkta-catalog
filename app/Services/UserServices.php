<?php
// app/Services/ExampleService.php

namespace App\Services;

use App\Models\NonWishlistUsers;
use App\Models\Product;
use App\Models\ProductAccessType;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserServices
{
    
    public function getRestrictedProducts(User $user){
        $accessTypes = ProductAccessType::get();
        #region Restrictions
        $restrictedProducts = array();
        foreach ($accessTypes as $key => $data) {
            $filterValue = array($user->id);
            if( $data->ref_type == 'indirect' ){
                $filterValue = DB::table($data->ref_table)->where('user_id', $user->id)->get()->pluck($data->ref_column)->toArray();
                
            }
            $isAllSelected = ProductRestriction::where('value',0)->where('product_access_type_id', $data->id)->get();
            if($isAllSelected->count() > 0){
                $restrictedProducts[$key] = ProductRestriction::where('value',0)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray();
            }else{
                $restrictedProducts[$key] = ProductRestriction::whereIn('value', $filterValue)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray();
            }
        }
        $mergeRestricted = array();
        foreach ($restrictedProducts as $key => $value) {
            $mergeRestricted = array_merge($mergeRestricted,$value);
        }
        $mergeRestricted = array_unique($mergeRestricted);
        #endregion
        #region Exemptions
        $exemptedProducts = array();
        foreach ($accessTypes as $key => $data) {
            $filterValue = array($user->id);
            if( $data->ref_type == 'indirect' ){
                $filterValue = DB::table($data->ref_table)->where('user_id', $user->id)->get()->pluck($data->ref_column)->toArray();
            }
            $isAllSelected = ProductExemption::where('value',0)->where('product_access_type_id', $data->id)->get();
            if($isAllSelected->count() > 0){
                $exemptedProducts[$key] = ProductExemption::where('value',0)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray();
            }else{
                $exemptedProducts[$key] = ProductExemption::whereIn('value', $filterValue)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray();
            }
        }
        $mergeExempted = array();
        foreach ($exemptedProducts as $key => $value) {
            $mergeExempted = array_merge($mergeExempted,$value);
        }
        $mergeExempted = array_unique($mergeExempted);
        #endregion
        $result = array_filter($mergeRestricted, function($value) use ($mergeExempted) {
            return !in_array($value, $mergeExempted);
        });

        
        return array_values($result);
    }
    public function getNonWishlistProducts(User $user){
        return collect(NonWishlistUsers::where('user_id', $user->id)->get())->pluck('product_id');
    }
}