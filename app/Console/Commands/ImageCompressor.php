<?php

namespace App\Console\Commands;

use App\Http\Controllers\FileController;
use App\Http\Controllers\OpenAPIController;
use App\Models\CompressImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImageCompressor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:image-compressor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compressed an Image to a specified resolution';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pending = CompressImage::where('status', 'pending')->take(100)->get();
        CompressImage::whereIn('id', $pending->pluck('id'))->update([
            'status' => 'ongoing',
        ]);
        foreach ($pending as $key => $row) {

            try {
                $imageKey = $row->image_key;
                $imageSize = $row->image_size;
                $path = $imageSize . 'x' . $imageSize;
                Storage::disk('public')->makeDirectory($path);

                $row->status = 'done';
                $row->save();
                $row->delete();
                
                if (
                    FileController::AWSFileExist('https://mkta-portal.s3.us-east-2.amazonaws.com/' ."thumbs/" . ($path) . "/" . $imageKey)
                ) { 
                    Log::info('Image Exists');
                    continue; 
                }
                OPenApiController::streamSave($imageKey, $imageSize);
                Storage::disk('s3')->put("thumbs/" . ($path) . "/" . $imageKey, file_get_contents(Storage::disk('public')->path($path . '/' . $imageKey)));

                Storage::disk('public')->delete($path . "/" . $imageKey);
                $row->status = 'done';
                $row->save();
                $row->delete();
            } catch (\Throwable $th) {
                Log::error($th);
                $row->status = 'error';
                $row->save();
            }
        }
    }
}
