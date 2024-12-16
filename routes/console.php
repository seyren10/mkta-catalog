<?php

use App\Http\Controllers\OpenAPIController;
use App\Models\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schedule;

Schedule::command('notification:new-product')->everyFiveMinutes();
Schedule::command('app:generate-news-letter')->thursdays()->at('08:00');

Artisan::command('fuck', function () {
    
});
Artisan::command('current', function () {

    $images = File::where('type', 'like', '%image%')->get();

    $this->info($images->count());
    $errors = collect([]);
    $open = new OpenAPIController();
    foreach ($images as $key => $row) {
        $imageKey = $row['filename'];
        try {

            $open->streamSave($imageKey, 100);
            Storage::disk('s3')->put("thumbs\\100x100\\" . $imageKey, file_get_contents(Storage::disk('public')->path('100x100\\' . $imageKey)));

            $open->streamSave($imageKey, 150);
            Storage::disk('s3')->put("thumbs\\150x150\\" . $imageKey, file_get_contents(Storage::disk('public')->path('150x150\\' . $imageKey)));

            $open->streamSave($imageKey, 200);
            Storage::disk('s3')->put("thumbs\\200x200\\" . $imageKey, file_get_contents(Storage::disk('public')->path('200x200\\' . $imageKey)));

            $open->streamSave($imageKey, 300);
            Storage::disk('s3')->put("thumbs\\300x300\\" . $imageKey, file_get_contents(Storage::disk('public')->path('300x300\\' . $imageKey)));

            $this->info($imageKey);
            $row->delete();
            
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
            $row->delete();
            $this->error($imageKey);
            $errors->push($imageKey);
        }
    }
    Log::error($errors->toArray());

});
