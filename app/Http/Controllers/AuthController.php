<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    protected $UserServices;

    public function __construct(UserServices $UserServices)
    {
        $this->UserServices = $UserServices;
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return response()->noContent();
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid Email or Password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'logout',
        ]);
    }

    public function getUserData(Request $request)
    {
        $request->merge(['includeRoleData' => true]);
        $request->session()->put('restricted_products', $this->UserServices->getRestrictedProducts(Auth()->user()));
        $request->session()->put('nonwishlist_products', $this->UserServices->getNonWishlistProducts(Auth()->user()));
        return new UserResource($request->user());
    }
}
