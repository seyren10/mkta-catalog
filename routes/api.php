<?php

use App\Http\Controllers\AreaCodeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyCodeController;
use App\Http\Controllers\currentController;
use App\Http\Controllers\NonWishlistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAccessTypeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserWishlistController;
use App\Models\ProductAccessType;
use App\Services\UserServices;
use Illuminate\Support\Facades\Route;

$except = ['create', 'edit', 'destroy'];

Route::get('/user', [AuthController::class, 'getUserData'])->middleware('auth:sanctum');

$except = ['create', 'edit', 'destroy'];

require __DIR__ . '/resources/products.php';
require __DIR__ . '/resources/categories.php';
require __DIR__ . '/resources/cms.php';
require __DIR__ . '/resources/files.php';
require __DIR__ . '/resources/filters.php';
require __DIR__ . '/resources/product-access.php';
require __DIR__ . '/resources/product-components.php';
require __DIR__ . '/resources/product-filter.php';
require __DIR__ . '/resources/product-images.php';
require __DIR__ . '/resources/recommended-products.php';
require __DIR__ . '/resources/related-products.php';
require __DIR__ . '/resources/users.php';
require __DIR__ . '/resources/imports.php';

Route::get('current/{category}', [currentController::class, 'current']);
Route::get('current-user/{user}', [UserServices::class, 'getRestrictedProducts']);


Route::apiResource('area-code', AreaCodeController::class)->except(['create', 'edit']);
Route::apiResource('company-code', CompanyCodeController::class)->except(['create', 'edit']);
Route::apiResource('roles', RolesController::class)->except(['create', 'edit']);
Route::post('roles/{role}/{action}/permissions/{permission}', [RolesController::class, 'modifyRolesPermission']);
Route::apiResource('permissions', PermissionController::class)->except(['create', 'edit']);
Route::apiResource('product-access-type', ProductAccessTypeController::class)->except(['create', 'edit']);
Route::put('data-table/product-access-type', [ProductAccessTypeController::class, 'batchUpdate']);
Route::get('notifications/{user}', [NotificationController::class, 'index']);

Route::delete('customer-wishlist/delete-all-user-wishlists', [UserWishlistController::class, 'destroyUserWishlistAll']);
Route::apiResource('customer-wishlist', UserWishlistController::class)->only(['store', 'index', 'destroy']);
Route::apiResource('non-wishlist', NonWishlistController::class)->only(["index", "store", "destroy"]);
