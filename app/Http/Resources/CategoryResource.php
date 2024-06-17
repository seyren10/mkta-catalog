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
                unset($data['parent_id']);
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
        return $data;
    }
}
