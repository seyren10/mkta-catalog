<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        $data['show_wishlist_button'] = false;
        if(auth()->user){
            $data['show_wishlist_button'] = $data['non_wishlist_users']->where('user_id', '=', auth()->user->id)->get()->count() > 0;
        }
        return $data;
    }
}
