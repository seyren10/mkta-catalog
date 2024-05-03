<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        $data['is_active'] = $data['is_active'] == 1;
        #region non-wishlist-products
        $curNonWishlistProducts = collect($data['non_wishlist_products']);
        unset($data['non_wishlist_products']);
        if( $request->has('includeNonWishlistProducts') ){
            if($request->includeNonWishlistProducts === 'true' || $request->includeNonWishlistProducts === true){
                $data['non_wishlist_products'] = $curNonWishlistProducts;
            }
        }
        if( $request->has('includeNonWishlistProductsKeys') ){
            if($request->includeNonWishlistProductsKeys === 'true' || $request->includeNonWishlistProductsKeys === true){
                $data['non_wishlist_products_keys'] = $curNonWishlistProducts->pluck('product_id');
            }
        }
        #endregion
        #region Area Code
        $removeAreasData = true;
        if( $request->has('includeAreasData') ){
            if($request->includeAreasData === 'true' || $request->includeAreasData === true){
                $removeAreasData = false;
            }
        }
        if ($removeAreasData) {
            unset($data['user_areas']);
        }
        #endregion
        #region Company Code
        $removeCompaniesData = true;
        if( $request->has('includeCompaniesData') ){
            if($request->includeCompaniesData === 'true' || $request->includeCompaniesData === true){
                $removeCompaniesData = false;
            }
        }
        if ($removeCompaniesData) {
            unset($data['user_companies']);
        }
        #endregion
        #region Role
        $removeRoleData = true;
        if( $request->has('includeRoleData') ){
            if($request->includeRoleData === 'true' || $request->includeRoleData === true){
                unset($data['role_id']);
                $removeRoleData = false;
            }
        }
        if ($removeRoleData) {
            unset($data['role_data']);
        }
        #endregion
        #region Permissions & Permission Keys
        $curPermissions =collect(( (array_merge($data['role_permissions'], $data['permissions']))))->unique();;
        unset($data['permissions']);
        unset($data['role_permissions']);
        if( $request->has('includePermissions') ){
            if($request->includePermissions === 'true' || $request->includePermissions === true){
                $data['permissions'] = $curPermissions;
            }
        }
        if( $request->has('includePermissionKeys') ){
            if($request->includePermissionKeys === 'true' || $request->includePermissionKeys === true){
                $data['permissions_keys'] = $curPermissions->pluck('key');
            }
        }
        #endregion
        return $data;
    }
}
