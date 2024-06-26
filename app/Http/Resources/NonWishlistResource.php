<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NonWishlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        #region Base on Request
        if (
            !$request->has('includeCustomer') &&
            !$request->has('includeKeys') &&
            !$request->has('includeProduct')
        ) {
            switch ($request->type) {
                case 'product':

                    return array(
                        "id" => $data['id'],
                        "data" => $data['user'],
                    ); // since the request is product the return value will be the list of restricted user
                    break;
                default:
                    return array(
                        "id" => $data['id'],
                        "data" => $data['product'],
                    ); // since the request is user the return value will be the list of restricted product
                    break;
            }
        }
        #endregion
        #region Customer
        $removeCustomer = true;
        if ($request->has('includeCustomer')) {
            if ($request->includeCustomer === 'true' || $request->includeCustomer === true) {
                $removeCustomer = false;
            }
        }
        if ($removeCustomer) {
            unset($data['user']);
        }
        #endregion
        #region Product
        $removeProduct = true;
        if ($request->has('includeProduct')) {
            if ($request->includeProduct === 'true' || $request->includeProduct === true) {
                $removeProduct = false;

            }
        }
        if ($removeProduct) {
            unset($data['product']);
        }
        #endregion
        #region Keys
        $removeKeys = true;
        if ($request->has('includeKeys')) {
            if ($request->includeKeys === 'true' || $request->includeKeys === true) {
                $removeKeys = false;
            }
        }
        if ($removeKeys) {
            unset($data['user_id']);
            unset($data['product_id']);

        }
        #endregion

        return $data;
    }
}
