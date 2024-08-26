<?php

use App\Http\Controllers\ExcelImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('imports')->controller(ExcelImportController::class)->group(function () {
    Route::post('product', 'importProducts');
});
