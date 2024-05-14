<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::post('/login', [AuthController::class, 'login']);
Route::delete('/logout', [AuthController::class, 'logout']);


Route::fallback(function () {
    return view('app');
});
