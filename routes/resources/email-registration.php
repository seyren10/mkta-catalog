<?php

use App\Http\Controllers\EmailRegistrationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('email-registration', EmailRegistrationController::class)->only(['store']);
