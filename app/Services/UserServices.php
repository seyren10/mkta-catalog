<?php
// app/Services/ExampleService.php

namespace App\Services;

use App\Models\NonWishlistUsers;
use App\Models\ProductAccessType;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserServices
{

    public function getRestrictedProducts(User $user)
    {

        #region New Code
        $accessTypes = ProductAccessType::get();
        #region Restrictions
        $restrictedProducts = array();
        foreach ($accessTypes as $key => $data) {
            $filterValue = array($user->id);
            if ($data->ref_type == 'indirect') {
                $filterValue = DB::table($data->ref_table)->where('user_id', $user->id)->get()->pluck($data->ref_column)->toArray();
            }
            $restrictedProducts[$key] = array_merge(
                ProductRestriction::whereIn('value', $filterValue)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray(),
                ProductRestriction::where('value', 0)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray(),
            );
        }
        $mergeRestricted = array();
        foreach ($restrictedProducts as $key => $value) {
            $mergeRestricted = array_merge($mergeRestricted, $value);
        }
        $mergeRestricted = array_unique($mergeRestricted);
        // Log::info($mergeRestricted);
        #endregion
        #region Exemptions
        $exemptedProducts = array();
        foreach ($accessTypes as $key => $data) {
            $filterValue = array($user->id);
            if ($data->ref_type == 'indirect') {
                $filterValue = DB::table($data->ref_table)->where('user_id', $user->id)->get()->pluck($data->ref_column)->toArray();
            }
            $exemptedProducts[$key] = array_merge(
                ProductExemption::whereIn('value', $filterValue)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray(),
                ProductExemption::where('value', 0)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray()
            );

        }
        $mergeExempted = array();
        foreach ($exemptedProducts as $key => $value) {
            $mergeExempted = array_merge($mergeExempted, $value);
        }
        $mergeExempted = array_unique($mergeExempted);
        #endregion
        $result = array_filter($mergeRestricted, function ($value) use ($mergeExempted) {
            return !in_array($value, $mergeExempted);
        });
        return array_values($result);
        #endregion
        #region Old Code
        $accessTypes = ProductAccessType::get();
        #region Restrictions
        $restrictedProducts = array();
        foreach ($accessTypes as $key => $data) {
            $filterValue = array($user->id);
            if ($data->ref_type == 'indirect') {
                $filterValue = DB::table($data->ref_table)->where('user_id', $user->id)->get()->pluck($data->ref_column)->toArray();

            }
            $restrictedProducts[$key] = ProductRestriction::whereIn('value', $filterValue)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray();
        }
        $mergeRestricted = array();
        foreach ($restrictedProducts as $key => $value) {
            $mergeRestricted = array_merge($mergeRestricted, $value);
        }
        $mergeRestricted = array_unique($mergeRestricted);
        #endregion
        #region Exemptions
        $exemptedProducts = array();
        foreach ($accessTypes as $key => $data) {
            $filterValue = array($user->id);
            if ($data->ref_type == 'indirect') {
                $filterValue = DB::table($data->ref_table)->where('user_id', $user->id)->get()->pluck($data->ref_column)->toArray();
            }
            $exemptedProducts[$key] = ProductExemption::whereIn('value', $filterValue)->where('product_access_type_id', $data->id)->get()->pluck('product_id')->toArray();
        }
        $mergeExempted = array();
        foreach ($exemptedProducts as $key => $value) {
            $mergeExempted = array_merge($mergeExempted, $value);
        }
        $mergeExempted = array_unique($mergeExempted);
        #endregion
        $result = array_filter($mergeRestricted, function ($value) use ($mergeExempted) {
            return !in_array($value, $mergeExempted);
        });
        return array_values($result);
        #endregion
    }
    public function getNonWishlistProducts(User $user)
    {
        return collect(NonWishlistUsers::where('user_id', $user->id)->get())->pluck('product_id');
    }
}
