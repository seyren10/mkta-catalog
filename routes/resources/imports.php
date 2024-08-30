<?php

use App\Http\Controllers\ExcelImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('data-imports')->controller(ExcelImportController::class)->group(function () {
    Route::get('templates/{template}', [ExcelImportController::class, 'template_downloads']);

    Route::post('products', [ExcelImportController::class, 'importProducts']);
    Route::post('related-and-recommended-products', [ExcelImportController::class, 'importProductsLink']);

    Route::post('categories', [ExcelImportController::class, 'importCategories']);
    
    Route::post('product-filters', [ExcelImportController::class, 'importFilters']);
    Route::post('product-restriction-and-exemptions', [ExcelImportController::class, 'importProductRestrictionExemption']);
});
