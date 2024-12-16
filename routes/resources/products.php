<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('product')->controller(ProductController::class)->group(function () {
        Route::get('/latest', [ProductController::class, 'latestProducts']);
        Route::get('/cached', [ProductController::class, 'indexCached']);
        Route::put('product-batch', [ProductController::class, 'batchUpdate']);
        Route::get('/random', [ProductController::class, 'randomProducts']);
    });

    Route::get('product-images/zip/{product}', [ProductController::class, "zipProductImages"]);
    Route::get('product/category/{category}', [ProductController::class, 'getProductsWithCategoryId']);
    Route::put('product-categories/{product}', [ProductController::class, "modifyProductCategories"]);
    Route::apiResource('product', ProductController::class)->except(['create', 'edit']);
    Route::put('data-table/product', [ProductController::class, 'batchUpdate']);
});