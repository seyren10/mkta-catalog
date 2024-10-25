<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        #region Category Thumbnail / File
        $removeFile = true;
        if ($request->has('includeFile')) {
            if ($request->includeFile === 'true' || $request->includeFile === true) {
                if ($data['file_id'] == null) {
                    $data['file'] = array(
                        "id" => 0,
                        "title" => "default image",
                        "filename" => "MKLogo-White.svg",
                    );
                }
                $data['img'] = $data['file']['filename'];
            }
        }
        if ($removeFile) {
            unset($data['file_id']);
            unset($data['file']);
        }
        #endregion
        #region Parent Category
        $removeParentCategory = true;
        if ($request->has('includeParentCategory')) {
            if ($request->includeParentCategory === 'true' || $request->includeParentCategory === true) {
                // unset($data['parent_id']);
                $removeParentCategory = false;
            }
        }
        if ($removeParentCategory) {
            unset($data['parent_category']);
        }
        #endregion
        #region Sub Categories
        $removeSubCategories = true;
        if ($request->has('includeSubCategories')) {
            if ($request->includeSubCategories === 'true' || $request->includeSubCategories === true) {
                $removeSubCategories = false;
            }
        }
        if ($removeSubCategories) {
            unset($data['sub_categories']);
        }
        #endregion
        #region Products
        $removeProducts = true;
        if ($request->has('includeProducts')) {
            if ($request->includeProducts === 'true' || $request->includeProducts === true) {
                $removeProducts = false;
            }
        }
        if ($removeProducts) {
            unset($data['products']);
        }
        #endregion
        #region Cover HTML
        $removeCoverHTML = true;
        if ($request->has('includeCoverHTML')) {
            if ($request->includeCoverHTML === 'true' || $request->includeCoverHTML === true) {
                $removeCoverHTML = false;
            }
        }
        if ($removeCoverHTML) {
            unset($data['cover_html']);
        }
        unset($data['cover_html']);
        #endregion
        if (!$request->has('includeBannerImage')){
            unset($data['banner_file']);
        }
        return $data;
    }
}
