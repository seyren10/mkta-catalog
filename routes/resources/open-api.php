<?php

use App\Http\Controllers\CompressImageController;
use App\Http\Controllers\OpenAPIController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;






Route::prefix('open-api')
    ->group(function () {
        Route::post('compress-image/{image_size}/{image_key}', [CompressImageController::class, 'store']);
        Route::get('current', [OpenAPIController::class, 'current_test']);
        
        Route::get('product-verification/{product}', [OpenAPIController::class, 'productVerification']);

        Route::get('product-images', [OpenAPIController::class, 'getProductImages']);
        Route::post('bc-api-merge', [OpenAPIController::class, 'updateDatafromBC']);
        Route::get('tms-product-images', [OpenAPIController::class, 'get_TMSProductAlbum']);
    });
