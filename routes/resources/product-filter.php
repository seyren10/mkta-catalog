<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductFilterController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('product-filter/{product}', [ProductFilterController::class, 'show']);
    Route::post('product-filter/{product}/{filter}/{filter_choice}', [ProductFilterController::class, 'store']);
    Route::delete('product-filter/{product}/{filter}/{filter_choice}', [ProductFilterController::class, 'destroy']);
});
