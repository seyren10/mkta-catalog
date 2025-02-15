<?php

namespace App\Http\Controllers;

use App\Models\CompressImage;

class CompressImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param image_key         : String    : object key in the AWS S3 Bucket.
     * @param image_size        : Integer   : desired image resolution
     */

    public static function createRequest($image_size, $image_key){
        CompressImage::create(
            [
                "image_key" => $image_key,
                "image_size" => $image_size,
                "status" => 'pending',
            ]
        );
    }

    public function store($image_size, $image_key)
    {
        self::createRequest($image_size, $image_key);
        return response(
            [
                "message" => "image is being compressed to " . $image_size,
            ]
            , 200);
    }
}
