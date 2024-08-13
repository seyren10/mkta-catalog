<?php

use App\Http\Controllers\AreaCodeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyCodeController;
use App\Http\Controllers\ContentManagementController;
use App\Http\Controllers\currentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FilterChoiceController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\NonWishlistController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductAccessController;
use App\Http\Controllers\ProductAccessTypeController;
use App\Http\Controllers\ProductComponentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFilterController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\RecommendedProductController;
use App\Http\Controllers\RelatedProductController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserWishlistController;
use App\Services\UserServices;
use Illuminate\Support\Facades\Route;






$except = ['create', 'edit', 'destroy'];

Route::get('/user', [AuthController::class, 'getUserData'])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->group(function () {
$except = ['create', 'edit', 'destroy'];

Route::get('s3-resources/{filename}', [FileController::class, 'show']);
Route::get('thumbnail/{code}', [FileController::class, 'show']);
Route::get('s3-resources-download/{filename}', [FileController::class, 'download']);
Route::apiResource('portal-files', FileController::class)->only(['store', 'index', 'update', 'destroy']);

Route::get('current/{category}', [currentController::class, 'current']);
Route::get('current-user/{user}', [UserServices::class, 'getRestrictedProducts']);


Route::apiResource('filters', FilterController::class)->except(['create', 'edit']);
Route::put('filter-batch', [FilterController::class, 'batchUpdate']);
Route::post('filters/choice/{filter}', [FilterChoiceController::class, 'store']);
Route::put('filters/choice/{filter_choice}', [FilterChoiceController::class, 'update']);
Route::delete('filters/choice/{filter_choice}', [FilterChoiceController::class, 'destroy']);



Route::apiResource('area-code', AreaCodeController::class)->except(['create', 'edit']);
Route::apiResource('company-code', CompanyCodeController::class)->except(['create', 'edit']);
Route::apiResource('roles', RolesController::class)->except(['create', 'edit']);
Route::apiResource('permissions', PermissionController::class)->except(['create', 'edit']);
Route::apiResource('categories', CategoryController::class)->except(['create', 'edit']);
Route::put('categories/image/{category}', [CategoryController::class, 'updateCoverPhoto']);
Route::put('categories/banner-image/{category}', [CategoryController::class, 'updateBannerImage']);



Route::apiResource('product-access-type', ProductAccessTypeController::class)->except(['create', 'edit']);
Route::get('product-access/{product_access}', [ProductAccessController::class, 'show']);
Route::post('product-access/{action_type}/{product}/{product_access}/{value}', [ProductAccessController::class, 'modify_ProductAccess']);
Route::delete('product-access/{action_type}/{product}/{product_access}/{value}', [ProductAccessController::class, 'modify_ProductAccess']);

#region Product Routes


Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::get('/latest', [ProductController::class, 'latestProducts']);
    Route::get('/cached', [ProductController::class, 'indexCached']);
Route::put('product-batch', [ProductController::class, 'batchUpdate']);
    Route::get('/random', [ProductController::class, 'randomProducts']);
});
Route::apiResource('product', ProductController::class)->except($except);
Route::get('product-images/zip/{product}', [ProductController::class, "zipProductImages"]);

Route::get('product/category/{category}', [ProductController::class, 'getProductsWithCategoryId']);
Route::put('product-categories/{product}', [ProductController::class, "modifyProductCategories"]);

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

#region Related Product
Route::apiResource('products/related', RelatedProductController::class)->only(['destroy']);
Route::post('products/related/{product}/{relatedProduct}', [RelatedProductController::class, 'store']);
Route::get('products/related/{product}', [RelatedProductController::class, 'show']);
#endregion 

#region Recommended Product

Route::apiResource('products/recommended', RecommendedProductController::class)->only(['destroy']);
Route::post('products/recommended/{product}/{recommendedProduct}', [RecommendedProductController::class, 'store']);
Route::get('products/recommended/{product}', [RecommendedProductController::class, 'show']);
#endregion 
#region Product Filter
Route::get('product-filter/{product}', [ProductFilterController::class, 'show']);
Route::post('product-filter/{product}/{filter}/{filter_choice}', [ProductFilterController::class, 'store']);
Route::delete('product-filter/{product}/{filter}/{filter_choice}', [ProductFilterController::class, 'destroy']);

#endregion

#endregion


Route::apiResource('users', UserController::class)->except($except);
Route::post('users/change-password-first-time', [UserController::class, 'changePasswordFirstTime']);
Route::put('users/change-password/{user}', [UserController::class, 'changePassword']);
Route::post('users/reset-password/{user}', [UserController::class, 'resetPassword']);
Route::post('users/{user}/{action}/permissions/{permission}', [UserController::class, 'modifyUserPermissions']);
Route::post('user/{user}/profile-picture', [UserController::class, 'uploadProfilePicture']);

Route::apiResource('customers', UserController::class)->except($except)->names('customers')->parameters(['customers' => 'user']);
Route::get('notifications/{user}', [NotificationController::class, 'index']);

Route::post('customers/reset-password/{user}', [UserController::class, 'resetPassword']);
Route::post('customers/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes']);
Route::post('customers/{user}/{action}/company-code/{company_code}', [UserController::class, 'modifyUserCompanyCode']);

Route::delete('customer-wishlist/delete-all-user-wishlists', [UserWishlistController::class, 'destroyUserWishlistAll']);
Route::apiResource('customer-wishlist', UserWishlistController::class)->only(['store', 'index', 'destroy']);
Route::apiResource('non-wishlist', NonWishlistController::class)->only(["index", "store", "destroy"]);


Route::post('roles/{role}/{action}/permissions/{permission}', [RolesController::class, 'modifyRolesPermission']);

Route::apiResource('content-management', ContentManagementController::class);
// });
