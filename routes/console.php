<?php

use App\Models\File;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;




Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('aws:compress-images', function () {
    $imageFiles = File::where('type', 'like', '%image%')->where('id', '>=', 1001)->get();
    $errors = [];
    foreach ($imageFiles as $key => $img) {
        try {
            $imageKey = $img->filename;
            $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/' . $imageKey));
            $image = Image::read($stream);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(Storage::disk('public')->path('') . $imageKey, quality: 50, progressive: true);
            Storage::disk('s3')->put("thumbs\\" . $imageKey, file_get_contents(Storage::disk('public')->path($imageKey)));
            $this->info("Success: " . $img->filename);
        } catch (\Throwable $th) {
            $this->error("Failed: " . $img->filename);
            $errors[] = $img->filename;
        }finally{
            
        }
    }
    Log::errors($errors);

});
