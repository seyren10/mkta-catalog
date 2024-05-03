<?php

use App\Http\Controllers\AreaCodeController;
use App\Http\Controllers\CompanyCodeController;
use App\Http\Controllers\NonWishlistController;
use App\Http\Controllers\NonWishlistUsersController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

$except = ['create', 'edit'];

Route::put('nonwishlist/{user}/{action}/{product}', NonWishlistController::class);

Route::apiResource('area-code', AreaCodeController::class)->except($except);
Route::apiResource('company-code', CompanyCodeController::class)->except($except);
Route::apiResource('users', UserController::class)->except('create', 'edit', 'destroy');
Route::apiResource('roles', RolesController::class)->except($except);
Route::apiResource('permissions', PermissionController::class)->except($except);

Route::put('users/change-password/{user}', [UserController::class, 'changePassword'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );

Route::post('users/reset-password/{user}', [UserController::class, 'resetPassword'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );

Route::post('users/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );

Route::post('users/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );

Route::post('users/{user}/{action}/company-code/{company_code}', [UserController::class, 'modifyUserCompanyCode'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );

Route::post('users/{user}/{action}/permissions/{permission}', [UserController::class, 'modifyUserPermissions'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );

Route::post('roles/{role}/{action}/permissions/{permission}', [RolesController::class, 'modifyRolesPermission'])
->fallback( function(){ return response()->json(["message"=>"Page not Found"],404); } );
