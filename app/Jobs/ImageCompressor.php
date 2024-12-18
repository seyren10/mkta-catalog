<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageCompressor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     * @param String imageKey
     * @param Int imageSize
     */
    protected $imageKey;
    protected $imageSize;

    public function __construct($imageKey, $imageSize)
    {
        $this->imageKey = $imageKey;
        $this->imageSize = $imageSize;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $path = $this->imageSize . 'x' . $this->imageSize;
            Storage::disk('s3')->makeDirectory('thumbs'."/".$path);
            Storage::disk('public')->makeDirectory($path);
            $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/' . $this->imageKey));
            $image = Image::read($stream);
            $image->resize($this->imageSize, $this->imageSize, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save(Storage::disk('public')->path($path.'/'.$this->imageKey), quality: 50, progressive: true);
            Storage::disk('s3')->put("thumbs/" . ($path) . "/" . $this->imageKey, file_get_contents(Storage::disk('public')->path($path. '/' . $this->imageKey)));
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        } finally {

        }
    }
}
