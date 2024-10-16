<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductImagesController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('product-images', [ProductImagesController::class, 'index']);
    Route::get('product-images/{product}', [ProductImagesController::class, 'show']);
    Route::post('product-images', [ProductImagesController::class, 'store']);
    Route::post('product-images-batch', [ProductImagesController::class, 'updateProductImages']);
    
    Route::put('product-images/{product_image}', [ProductImagesController::class, 'update']);
    Route::patch('product-images/{product_image}', [ProductImagesController::class, 'move']);
    Route::delete('product-images/{product_image}', [ProductImagesController::class, 'destroy']);
});
