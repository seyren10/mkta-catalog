<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentManagementController;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('content-management', ContentManagementController::class);
    Route::prefix('content-management')->group(function () {
        Route::put('/set-active-content/{content_management}', [ContentManagementController::class, 'setActiveContent']);
    });
});
