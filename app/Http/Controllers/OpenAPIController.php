<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class OpenAPIController extends Controller
{

    public function current_test(Request $request)
    {
        $imageKey = '004MdEUfvAl8eUXeON7NYGhLoQKTKJTKQHdrVuCD.jpg';
        $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/'.$imageKey));
        $image = Image::read($stream);
        $image->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(Storage::disk('public')->path('') . $imageKey, quality: 50, progressive: true);
        Storage::disk('s3')->put("thumbs\\".$imageKey, file_get_contents(Storage::disk('public')->path($imageKey)));
        return;
    }

    public function current_test_all(Request $request)
    {
        $imageKey = '004MdEUfvAl8eUXeON7NYGhLoQKTKJTKQHdrVuCD.jpg';
        $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/'.$imageKey));
        $image = Image::read($stream);
        $image->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(Storage::disk('public')->path('') . $imageKey, quality: 10, progressive: true);
        Storage::disk('s3')->put("thumbs\\".$imageKey, file_get_contents(Storage::disk('public')->path($imageKey)));
        return;
    }

    public function current_test_working_local(Request $request)
    {
        // https: //mkta-portal.s3.us-east-2.amazonaws.com/

        $data = Storage::disk('public')->get("SampleCompression.PNG");
        $image = Image::read($data);
        $image->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(Storage::disk('public')->path('') . "/fuckthislife.jpg", quality: 10, progressive: true);
    }

    public function get_TMSProductAlbum(Request $request)
    {
        $passPhrase = env('APP_OPEN_KEY');
        if ($passPhrase != $request->passPhrase) {
            return response()->json(['message' => 'Incorrect passphrase.'], 401);
        }
        $collect = ProductImage::get();
        $prodImages = $collect->map(function ($row) {
            $data = array();
            $data['prod_code'] = $row['product_id'];
            $data['img_index'] = $row['index'];
            $data['filename'] = $row['file']['filename'];
            // return $data;
            return $data;
        })->groupBy('prod_code');
        return response()->json(['message' => 'Product Images Exported', 'data' => $prodImages], 200);
    }

    public function getProductImages(Request $request)
    {

        $passPhrase = env('APP_OPEN_KEY');
        if ($passPhrase != $request->passPhrase) {
            return response()->json(['message' => 'Incorrect passphrase.'], 401);
        }

        $collect = ProductImage::get();
        return $collect->map(function ($row) {
            unset($row['id']);
            unset($row['file_id']);
            unset($row['is_thumbnail']);
            unset($row['index']);
            unset($row['file']['id']);
            unset($row['file']['type']);
            return $row;
        });
    }

    public function updateDatafromBC(Request $request)
    {
        $passPhrase = env('APP_OPEN_KEY');

        if (!$request->has('passPhrase')) {
            return response()->json(['message' => 'Passphrase is required.'], 401);
        }

        if ($passPhrase != $request->passPhrase) {
            return response()->json(['message' => 'Incorrect passphrase.'], 403);
        }

        if (!$request->has('data')) {
            return response()->json(['message' => 'Data is required.'], 401);
        }

        try {

            $data = $request->data;
            if (gettype($data) == 'string') {
                $data = json_decode($data);
            }
            if (!is_array($data)) {
                $data = array($data);
            }

            $msg = 'Product Updated Successfully';
            $msgCode = 200;
            foreach ($data as $key => $product) {

                // echo gettype($product);
                $product = (array) $product;
                // die();
                Product::upsert(
                    $product,
                    uniqueBy: [
                        'id',
                    ],
                    update: [
                        'parent_code',
                        'title',
                        'description',

                        'volume',
                        'weight_net',
                        'weight_gross',
                        'dimension_length',
                        'dimension_width',
                        'dimension_height',
                    ]
                );
            }

        } catch (\Throwable $th) {
            $msg = $th->getMessage();
            $msgCode = 500;
        } finally {
            return response()->json(['message' => $msg], $msgCode);
        }
    }
}
