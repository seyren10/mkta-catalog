<?php

use App\Http\Controllers\AreaCodeController;
use App\Http\Controllers\CompanyCodeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAccessTypeController;
use App\Http\Controllers\ProductComponentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SingleActionController\NonWishlistController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$except = ['create', 'edit', 'destroy'];


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('current/{product_access_type}', [FileController::class, 'useExampleService']);
Route::put('nonwishlist/{user}/{action}/{product}', NonWishlistController::class);

Route::apiResource('area-code', AreaCodeController::class)->except($except);
Route::apiResource('company-code', CompanyCodeController::class)->except($except);
Route::apiResource('roles', RolesController::class)->except($except);
Route::apiResource('permissions', PermissionController::class)->except($except);

Route::apiResource('categories', PermissionController::class)->except($except);
Route::apiResource('product', ProductController::class)->except($except);

Route::apiResource('product-access-type', ProductAccessTypeController::class)->except($except);

Route::apiResource('product-components', ProductComponentController::class)->only(['update', 'destroy']);
Route::get('product-components/{product}', [ProductComponentController::class, 'showProductComponents']);
Route::post('product-components/{product}', [ProductComponentController::class, 'createProductComponents']);

Route::apiResource('users', UserController::class)->except($except);
Route::group(['users'], function (){
    Route::put('/change-password/{user}', [UserController::class, 'changePassword']);
    Route::post('/reset-password/{user}', [UserController::class, 'resetPassword']);
    Route::post('/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes']);
    Route::post('/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes']);
    Route::post('/{user}/{action}/company-code/{company_code}', [UserController::class, 'modifyUserCompanyCode']);
    Route::post('/{user}/{action}/permissions/{permission}', [UserController::class, 'modifyUserPermissions']);
});

Route::post('roles/{role}/{action}/permissions/{permission}', [RolesController::class, 'modifyRolesPermission']);