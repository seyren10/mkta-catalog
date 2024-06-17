<?php

use App\Http\Controllers\AreaCodeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyCodeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAccessTypeController;
use App\Http\Controllers\ProductComponentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SingleActionController\NonWishlistController;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$except = ['create', 'edit', 'destroy'];

Route::get('/user', function (Request $request) {
    $request->merge(['includeRoleData' => true]);
    return new UserResource($request->user());
})->middleware('auth:sanctum');

Route::get('current/{product_access_type}', [FileController::class, 'useExampleService']);
Route::put('nonwishlist/{user}/{action}/{product}', NonWishlistController::class);

Route::apiResource('area-code', AreaCodeController::class)->except(['create', 'edit']);
Route::apiResource('company-code', CompanyCodeController::class)->except(['create', 'edit']);
Route::apiResource('roles', RolesController::class)->except(['create', 'edit']);
Route::apiResource('permissions', PermissionController::class)->except(['create', 'edit']);

Route::apiResource('categories', CategoryController::class)->except(['create', 'edit']);
Route::apiResource('product', ProductController::class)->except($except);

Route::apiResource('product-access-type', ProductAccessTypeController::class)->except(['create', 'edit']);

Route::apiResource('product-components', ProductComponentController::class)->only(['update', 'destroy']);
Route::get('product-components/{product}', [ProductComponentController::class, 'showProductComponents']);
Route::post('product-components/{product}', [ProductComponentController::class, 'createProductComponents']);

Route::apiResource('users', UserController::class)->except($except);
Route::put('users/change-password/{user}', [UserController::class, 'changePassword']);
Route::post('users/reset-password/{user}', [UserController::class, 'resetPassword']);
Route::post('users/{user}/{action}/permissions/{permission}', [UserController::class, 'modifyUserPermissions']);

Route::apiResource('customers', UserController::class)->except($except)->names('customers')->parameters(['customers' => 'user']);
Route::post('customers/reset-password/{user}', [UserController::class, 'resetPassword']);
Route::post('customers/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes']);
Route::post('customers/{user}/{action}/company-code/{company_code}', [UserController::class, 'modifyUserCompanyCode']);

Route::post('roles/{role}/{action}/permissions/{permission}', [RolesController::class, 'modifyRolesPermission']);
