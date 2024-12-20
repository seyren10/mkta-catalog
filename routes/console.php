<?php

use App\Models\CompressImage;
use Illuminate\Support\Facades\Schedule;


Schedule::command('notification:new-product')->everyFiveMinutes();
Schedule::command('app:generate-news-letter')->thursdays()->at('08:00');

Schedule::command('app:image-compressor')->everyThreeMinutes();
Schedule::call(function(){
    CompressImage::onlyTrashed()->forceDelete();
})->dailyAt('00:00');
