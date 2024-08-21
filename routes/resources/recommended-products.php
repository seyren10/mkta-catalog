<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendedProductController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products/recommended', RecommendedProductController::class)->only(['destroy']);
    Route::post('products/recommended/{product}/{recommendedProduct}', [RecommendedProductController::class, 'store']);
    Route::get('products/recommended/{product}', [RecommendedProductController::class, 'show']);
});
