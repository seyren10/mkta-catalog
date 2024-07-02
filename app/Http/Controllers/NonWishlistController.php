<?php

namespace App\Http\Controllers;

use App\Http\Resources\NonWishlistResource;
use App\Models\NonWishlistUsers;
use Illuminate\Http\Request;

class NonWishlistController extends Controller
{

    public function index(Request $request)
    {
        $type = 'product_id';
        switch ($request->type) {
            case 'product':
                $type = 'product_id';
                break;
            case 'customer':
                $type = 'user_id';
                break;
            case 'user':
                $type = 'user_id';
                break;
            default:
                return response()->json(["message" => "method not found"], 422);
                break;
        }
        return NonWishlistResource::collection(NonWishlistUsers::where($type, $request->value)->get());
    }
    public function store(Request $request)
    {
        $isIncluded = NonWishlistUsers::where('user_id', $request->user_id)->where('product_id', $request->product_id);
        if ($isIncluded->get()->count() > 0) {
            return response()->json(["message" => "Already Added"], 200);
        }
        NonWishlistUsers::create(
            array(
                "product_id" => $request->product_id,
                "user_id" => $request->user_id,
            )
        );
        return response()->json(["message" => "Added"], 200);

    }
    public function destroy(NonWishlistUsers $nonwishlist)
    {
        $nonwishlist->delete();
        return response()->json(["message" => "Deleted"], 200);
    }
}
