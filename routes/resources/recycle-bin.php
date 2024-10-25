<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecycleBinController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('recycle-bin/{type}', [RecycleBinController::class, 'index']);
    Route::post('recycle-bin/{type}/restore', [RecycleBinController::class, 'restore']);
});
