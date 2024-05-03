<?php

namespace App\Http\Controllers;

use App\Models\NonWishlistUsers;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class NonWishlistController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, $action, Product $product){
        switch ($action) {
            case 'append':
                $isIncluded = NonWishlistUsers::where('user_id', $user->id)->where('product_id', $product->id);
                if($isIncluded->get()->count() > 0){
                    return response()->json(["message" => "Adding Product ".$product->title." to wishlist is already restricted to  ".$user->name.""], 201);
                }
                NonWishlistUsers::create(
                    array(
                        "product_id" => $product->id,
                        "user_id" => $user->id
                    )
                );
                return response()->json(["message" => "Product ".$product->title." is restricted to ".$user->name." in adding it to his wishlist"], 200);
                break;
            case 'remove':
                NonWishlistUsers::where('user_id', $user->id)->where('product_id', $product->id)->delete();
                return response()->json(["message" => "Product ".$product->title." is not restricted to be added to the wishlist of ".$user->name], 200);
                break;
            default:
                return response()->json(["message" => "Method not found"], 404);
                break;
        }
    }
}
