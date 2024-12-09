<?php

use App\Models\File;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;





Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('current', function () {
    $serv = new UserServices;
    $user = User::find(2);
    Log::info($serv->getRestrictedProducts($user));
});
