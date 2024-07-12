<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        #region Wishlist Button
        $data['show_wishlist_button'] = false;
        #endregion
        #region Product Categories
        $removeProductCategories = true;
        if ($request->has('includeProductCategories')) {
            if ($request->includeProductCategories === 'true' || $request->includeProductCategories === true) {
                $removeProductCategories = false;
            }
        }
        if ($removeProductCategories) {
            unset($data['product_categories']);
        }
        #endregion
        #region Product Categories
        if ($request->has('includeProductCategoryKeys')) {
            if ($request->includeProductCategoryKeys === 'true' || $request->includeProductCategoryKeys === true) {
                $data['product_category_keys'] = (collect($data['product_categories']))->pluck('id');
            }
        }
        #endregion
        #region Product Components
        $removeProductComponents = true;
        if ($request->has('includeProductComponents')) {
            if ($request->includeProductComponents === 'true' || $request->includeProductComponents === true) {
                $removeProductComponents = false;
            }
        }
        if ($removeProductComponents) {
            unset($data['product_components']);
        }
        #endregion
        #region Non-Wishlist Users
        $removeNonWishlistUsers = true;
        if ($request->has('includeNonWishlistUser')) {
            if ($request->includeNonWishlistUser === 'true' || $request->includeNonWishlistUser === true) {
                $removeNonWishlistUsers = false;
            }
        }
        if ($removeNonWishlistUsers) {
            unset($data['non_wishlist_users']);
        }
        #endregion
        #region Product Images
        $removeProductImages = true;
        if ($request->has('includeProductImages')) {
            if ($request->includeProductImages === 'true' || $request->includeProductImages === true) {
                $removeProductImages = false;
            }
        }
        if ($removeProductImages) {
            unset($data['product_images']);
        }
        #endregion
        #region Product Dimensions
        $removeProductDimensions = true;
        if ($request->has('includeProductDimensions')) {
            if ($request->includeProductDimensions === 'true' || $request->includeProductDimensions === true) {
                $removeProductDimensions = false;
            }
        }
        if ($removeProductDimensions) {
            unset($data['dimension_height']);
            unset($data['dimension_width']);
            unset($data['dimension_length']);
        }
        #endregion
        #region Product Weight
        $removeProductWeight = true;
        if ($request->has('includeProductWeight')) {
            if ($request->includeProductWeight === 'true' || $request->includeProductWeight === true) {
                $removeProductWeight = false;
            }
        }
        if ($removeProductWeight) {
            unset($data['weight_net']);
            unset($data['weight_gross']);
        }
        #endregion
        #region Product Volume
        $removeProductVolume = true;
        if ($request->has('includeProductVolume')) {
            if ($request->includeProductVolume === 'true' || $request->includeProductVolume === true) {
                $removeProductVolume = false;
            }
        }
        if ($removeProductVolume) {
            unset($data['volume']);
        }
        #endregion
        #region Product Parent Code
        $removeParentCode = true;
        if ($request->has('includeParentCode')) {
            if ($request->includeParentCode === 'true' || $request->includeParentCode === true) {
                $removeParentCode = false;
            }
        }
        if ($removeParentCode) {
            unset($data['parent_code']);
        }

        if ($request->has('includeVariants')) {
            $data['variants'] = Product::variants($this);
        }
        #endregion
        #region Related Products
        $removeRelatedProduct = true;
        if ($request->has('includeRelatedProducts')) {
            if ($request->includeRelatedProducts === 'true' || $request->includeRelatedProducts === true) {
                $removeRelatedProduct = false;
            }
        }
        if ($removeRelatedProduct) {
            unset($data['related_product']);
        }
        #endregion
        #region Recommended Products
        $removeRecommendedProduct = true;
        if ($request->has('includeRecommendedProduct')) {
            if ($request->includeRecommendedProduct === 'true' || $request->includeRecommendedProduct === true) {
                $removeRecommendedProduct = false;
            }
        }
        if ($removeRecommendedProduct) {
            unset($data['recommended_product']);
        }
        #endregion
        #region Product Filter
        $removeProductFilter = true;
        if ($request->has('includeProductFilter')) {
            if ($request->includeProductFilter === 'true' || $request->includeProductFilter === true) {
                $removeProductFilter = false;
                $data['product_filter'] = collect($data['product_filter'])->pluck('filter_key');
            }
        }
        if ($removeProductFilter) {
            unset($data['product_filter']);
        }
        #endregion

        return $data;
    }
}
