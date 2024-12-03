<?php

use App\Http\Controllers\OpenAPIController;
use Illuminate\Support\Facades\Route;

Route::prefix('open-api')
    ->group(function () {
        Route::get('product', [OpenAPIController::class, 'getProduct']);
        Route::get('product-images', [OpenAPIController::class, 'getProductImages']);
        Route::post('bc-api-merge', [OpenAPIController::class, 'updateDatafromBC']);

    });
