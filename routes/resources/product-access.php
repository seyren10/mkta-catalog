<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductAccessController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('product-access/{product_access}', [ProductAccessController::class, 'show']);
    Route::post('product-access/{action_type}/{product}/{product_access}/{value}', [ProductAccessController::class, 'modify_ProductAccess']);
    Route::delete('product-access/{action_type}/{product}/{product_access}/{value}', [ProductAccessController::class, 'modify_ProductAccess']);
});
