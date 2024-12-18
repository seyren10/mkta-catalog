<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;




Route::post('compress-image/{file}', [FileController::class, 'imageCompressor']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('s3-resources/{filename}', [FileController::class, 'show']);
    Route::get('thumbnail/{code}', [FileController::class, 'show']);
    Route::get('s3-resources-download/{filename}', [FileController::class, 'download']);
    Route::apiResource('portal-files', FileController::class)->only(['store', 'index', 'update', 'destroy']);
});
