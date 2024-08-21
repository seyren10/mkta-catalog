<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

$except = ['create', 'edit', 'destroy'];


Route::middleware(['auth:sanctum'])->group(function () use ($except) {
    Route::apiResource('users', UserController::class)->except($except);
    Route::post('users/change-password-first-time', [UserController::class, 'changePasswordFirstTime']);
    Route::put('users/change-password/{user}', [UserController::class, 'changePassword']);
    Route::post('users/reset-password/{user}', [UserController::class, 'resetPassword']);
    Route::post('users/{user}/{action}/permissions/{permission}', [UserController::class, 'modifyUserPermissions']);
    Route::post('user/{user}/profile-picture', [UserController::class, 'uploadProfilePicture']);

    Route::apiResource('customers', UserController::class)->except($except)->names('customers')->parameters(['customers' => 'user']);

    Route::post('customers/reset-password/{user}', [UserController::class, 'resetPassword']);
    Route::post('customers/{user}/{action}/area-code/{areacode}', [UserController::class, 'modifyUserAreaCodes']);
    Route::post('customers/{user}/{action}/company-code/{company_code}', [UserController::class, 'modifyUserCompanyCode']);
});
