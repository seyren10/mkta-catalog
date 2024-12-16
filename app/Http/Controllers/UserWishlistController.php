<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Models\UserWishlist;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Exports\WishListExport;
use App\Services\EntraMailService;

use Maatwebsite\Excel\Facades\Excel;

class UserWishlistController extends Controller
{
    public function __construct(){
        $this->email_service = new EntraMailService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
        USE THIS WHEN ROLES ARE CONFIGURED TO BE
        SOMETHING LIKE ADMIN OR CONTENT MANAGER

        if (Auth::user()->role_id === 'something') {
            return response()->json([
                'data' => UserWishlist::all()
            ]);
        }
        */

        //User specific wishlist
        $wishlists = Auth::user()->wishlists()->with('product')->get();

        //map the wishlists to only contain the product and wishlistId and not other information
        $products = $wishlists->map(function ($wishlist) {
            return [
                'id' => $wishlist->id,
                'product' => $wishlist->product
            ];
        });

        return response()->json([
            'data' => $products
        ]);
    }
    public function getWishlist(User $user)
    {
        $product_list = UserWishlist::where('user_id', $user->id)->get()->pluck('product_id');

        return ProductResource::collection(Product::whereNotIn('id', $request->session()->get('restricted_products', array()))->whereIn('id', $product_list)->get());
    }

    public function store(Request $request)
    {
        Auth::user()->wishlists()->create([
            'product_id' => $request->product_id,
        ]);

        return response()->noContent();

        // if( $request->action == 'append' ){
        //     UserWishlist::create(
        //         array(
        //             "product_id" => $request->product_id,
        //             "user_id" => $request->user_id
        //         )
        //     );
        //     return response(array(
        //         "message" => "Product is added in the wishlist"
        //     ),200);
        // }else{
        //     UserWishlist::where('product_id', $request->id)->where('user_id', $request->user_id)->delete();
        //     return response(array(
        //         "message" => "Product is removed in the wishlist"
        //     ),200);
        // }

    }


    /*  Delete the wishlist of the currently
    logged in user */
    public function destroy(UserWishlist $customer_wishlist)
    {

        $customer_wishlist->delete();

        return response()->noContent();
    }

    /*  Delete all of the wishlist of the currently
    logged in user */
    public function destroyUserWishlistAll()
    {
        Auth::user()->wishlists()->delete();

        return response()->noContent();
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function sendWishlist(Request $request)
    {
        try {
            $user = Auth::user();
            $recipient = config('notification.wishlist.recipient');

            // Retrieve products from request
            $products = Product::whereIn('id', $request->productCodes)->get();
            $filename = 'wishlist.xlsx';

            // Store the Excel as a file
            $filePath = storage_path('/app/' . $filename);
            Excel::store(new WishListExport($products), $filename, 'local');

            // Open the file and convert it to a Guzzle stream
            $fileStream = fopen($filePath, 'r');
            if ($fileStream === false) {
                throw new \RuntimeException("Failed to open file: $filePath");
            }

            // Send the stream directly
            $response = $this->email_service->sendMailWithAttachment(
                'Wishlist Request from ' . ($user ? $user->name : "Test User"),
                $request->message,
                $recipient,
                $filePath,
                $filename,
                false // Use HTML body
            );

            return response()->json([
                "message" => "Wishlist has been sent!",
                "data" => $response
            ], 200);
        } catch (\Throwable $e) {
            \Log::error($e);
            $message = "Error: " . $e->getMessage();

            return response()->json([
                "message" => $message
            ], 400);
        }
    }
}
