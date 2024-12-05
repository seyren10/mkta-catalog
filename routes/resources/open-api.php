<?php

use App\Http\Controllers\OpenAPIController;
use Illuminate\Support\Facades\Route;

Route::prefix('open-api')
    ->group(function () {
        Route::get('current', [OpenAPIController::class, 'current_test']);
        Route::get('product-images', [OpenAPIController::class, 'getProductImages']);
        Route::post('bc-api-merge', [OpenAPIController::class, 'updateDatafromBC']);
        Route::get('tms-product-images', [OpenAPIController::class, 'get_TMSProductAlbum']);
    });
