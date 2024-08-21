<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RelatedProductController;


Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products/related', RelatedProductController::class)->only(['destroy']);
    Route::post('products/related/{product}/{relatedProduct}', [RelatedProductController::class, 'store']);
    Route::get('products/related/{product}', [RelatedProductController::class, 'show']);
});
