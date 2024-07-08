<?php

use App\Http\Controllers\AreaCodeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyCodeController;
use App\Http\Controllers\currentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NonWishlistController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAccessController;
use App\Http\Controllers\ProductAccessTypeController;
use App\Http\Controllers\ProductComponentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWishlistController;
use App\Http\Resources\ProductAccessResource;
use App\Http\Resources\UserResource;
use App\Models\ProductAccessType;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;



$except = ['create', 'edit', 'destroy'];

Route::get('/user', function (Request $request) {
    $request->merge(['includeRoleData' => true]);
    return new UserResource($request->user());
})->middleware('auth:sanctum');

Route::get('s3-resources/{filename}',[FileController::class, 'show']);
Route::get('thumbnail/{code}',[FileController::class, 'show']);
Route::get('s3-resources-download/{filename}',[FileController::class, 'download']);
// Route::post('s3-resources-upload',[FileController::class, 'store']);
Route::apiResource('portal-files', FileController::class)->only(['store', 'index', 'update', 'destroy']);

Route::get('current/{category}', [currentController::class, 'current']);
Route::get('current-user/{user}', [UserServices::class, 'getRestrictedProducts']);

Route::get('product-access/{product_access}', [ProductAccessController::class, 'show']);
Route::post('product-access/{action_type}/{product}/{product_access}/{value}', [ProductAccessController::class, 'modify_ProductAccess']);
Route::delete('product-access/{action_type}/{product}/{product_access}/{value}', [ProductAccessController::class, 'modify_ProductAccess']);




Route::apiResource('area-code', AreaCodeController::class)->except(['create', 'edit']);
Route::apiResource('company-code', CompanyCodeController::class)->except(['create', 'edit']);
Route::apiResource('roles', RolesController::class)->except(['create', 'edit']);
Route::apiResource('permissions', PermissionController::class)->except(['create', 'edit']);

Route::apiResource('categories', CategoryController::class)->except(['create', 'edit']);
Route::apiResource('product', ProductController::class)->except($except);
Route::get('product/category/{category}', [ProductController::class, 'getProductsWithCategoryId']);
Route::put('product-categories/{product}', [ProductController::class, "modifyProductCategories"]);

Route::apiResource('product-access-type', ProductAccessTypeController::class)->except(['create', 'edit']);

Route::get('product-images', [ProductImagesController::class, 'index']);
Route::get('product-images/{product}', [ProductImagesController::class, 'show']);
Route::post('product-images', [ProductImagesController::class, 'store']);
Route::put('product-images/{product_image}', [ProductImagesController::class, 'update']);
Route::patch('product-images/{product_image}', [ProductImagesController::class, 'move']);
Route::delete('product-images/{product_image}', [ProductImagesController::class, 'destroy']);

Route::get('product-components/{product}', [ProductComponentController::class, 'showProductComponents']);
Route::post('product-components/{product}', [ProductComponentController::class, 'createProductComponents']);
Route::put('product-components/{product_component}', [ProductComponentController::class, 'update']);
Route::delete('product-components/{product_component}', [ProductComponentController::class, 'destroy']);

Route::apiResource('users', UserController::class)->except($except);
Route::put('users/change-password/{user}', [UserController::class, 'changePassword']);
Route::post('users/reset-password/{user}', [UserController::class, 'resetPassword']);
Route::post('users/{user}/{action}/permissions/{permission}', [UserController::class, 'modifyUserPermissions']);

Route::apiResource('customers', UserController::class)->except($except)->names('customers')->parameters(['customers' => 'user']);
Route::post('customers/reset-password/{user}', [UserController::class, 'resetPassword']);
Route::post('customers/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes']);
Route::post('customers/{user}/{action}/company-code/{company_code}', [UserController::class, 'modifyUserCompanyCode']);
Route::apiResource('customer-wishlist', UserWishlistController::class)->only(['store']);
Route::get('customer-wishlist/{user}', [UserWishlistController::class, 'getWishlist']);
Route::apiResource('non-wishlist', NonWishlistController::class)->only(["index", "store", "destroy"]);


Route::post('roles/{role}/{action}/permissions/{permission}', [RolesController::class, 'modifyRolesPermission']);
