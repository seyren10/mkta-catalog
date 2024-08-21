<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::put('categories/image/{category}', [CategoryController::class, 'updateCoverPhoto']);
    Route::put('categories/banner-image/{category}', [CategoryController::class, 'updateBannerImage']);
});
