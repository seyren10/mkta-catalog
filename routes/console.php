<?php

use App\Http\Controllers\OpenAPIController;
use App\Jobs\ImageCompressor;
use App\Models\File;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schedule;

Schedule::command('notification:new-product')->everyFiveMinutes();
Schedule::command('app:generate-news-letter')->thursdays()->at('08:00');
