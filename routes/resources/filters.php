<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\FilterChoiceController;


Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('filters', FilterController::class)->except(['create', 'edit']);
    Route::put('filter-batch', [FilterController::class, 'batchUpdate']);
    Route::put('data-table/filter', [FilterController::class, 'batchUpdate']);
    Route::post('filters/choice/{filter}', [FilterChoiceController::class, 'store']);
    Route::put('filters/choice/{filter_choice}', [FilterChoiceController::class, 'update']);
    Route::delete('filters/choice/{filter_choice}', [FilterChoiceController::class, 'destroy']);
});
