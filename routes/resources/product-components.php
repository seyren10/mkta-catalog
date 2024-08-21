<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductComponentController;

Route::middleware(['auth:sanctum'], function () {
    Route::get('product-components/{product}', [ProductComponentController::class, 'showProductComponents']);
    Route::post('product-components/{product}', [ProductComponentController::class, 'createProductComponents']);
    Route::put('product-components/{product_component}', [ProductComponentController::class, 'update']);
    Route::delete('product-components/{product_component}', [ProductComponentController::class, 'destroy']);
});
