<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Models\UserWishlist;
use Illuminate\Http\Request;

class UserWishlistController extends Controller
{

    
    public function getWishlist(User $user){
        $product_list = UserWishlist::where('user_id', $user->id)->get()->pluck('product_id');
        return ProductResource::collection(Product::whereIn('id', $product_list)->get());
    }

    public function store(Request $request)
    {
        UserWishlist::create(
            array(
                "product_id" => $request->product_id,
                "user_id" => $request->user_id
            )
        );
        return response(array(
            "message" => "Product is added in the wishlist"
        ),200);
    }

    public function destroy(UserWishlist $customer_wishlist)
    {
        UserWishlist::where('id', $customer_wishlist->id)->delete();
        return response(array(
            "message" => "Product is removed in the wishlist"
        ),200);
    }

    
    /**
     * Display the specified resource.
     */
    public function show(UserWishlist $userWishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserWishlist $userWishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserWishlist $userWishlist)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
}
