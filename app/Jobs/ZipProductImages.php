<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\User;
use App\Notifications\ZipProductImages_Download;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Madnest\Madzipper\Madzipper;

class ZipProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $product_id;
    protected $user_id;

    public function __construct($product_id, $user_id)
    {
        $this->product_id = $product_id;
        $this->user_id = $user_id;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $current_user = User::where('id', '=', $this->user_id)->get()->first();
        $product = Product::findOrFail($this->product_id);
        $array = array(
            "filename" => "",
            "product" => $product->id,
        );
        $productData = $product->toArray();
        $data = "";
        try {
            $zipFile = $product->id . ".zip";
            if (Storage::disk("s3")->exists("zip/" . $zipFile)) {
                $data = "zip/".$zipFile;
                return;
            }
            $zipper = new Madzipper;
            $zipper->make($zipFile);
            foreach ($product->product_images as $key => $value) {
                $filename = $value->file->filename;
                $zipper->addString($filename, Storage::disk('s3')->get($filename));
            }
            $zipper->close();
            $data = Storage::disk('s3')->putFileAs('zip', new File($zipFile), $zipFile);
            unlink($zipFile);
            
        } catch (\Throwable $th) {
            
        } finally {
            foreach ( $productData as $key => $value) {
                if(!in_array($key,['id', 'title', 'description', 'product_thumbnail'])){
                    unset($productData[$key]);
                }
            }

            $array = array(
                "filename" => $data,
                "product" => $productData,
            );

            $current_user->notify(
                new ZipProductImages_Download($array)
            );
        }

    }
}
