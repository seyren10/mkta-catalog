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
        $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/' . $imageKey));
        $image = Image::read($stream);
        $image->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(Storage::disk('public')->path('') . $imageKey, quality: 50, progressive: true);
        Storage::disk('s3')->makeDirectory('thumbs\\150x150');
        Storage::disk('s3')->makeDirectory('thumbs\\200x200');
        Storage::disk('s3')->makeDirectory('thumbs\\300x300');
        Storage::disk('s3')->put("thumbs\\" . $imageKey, file_get_contents(Storage::disk('public')->path($imageKey)));
        return;
    }

    public function current_test_all(Request $request)
    {
        $imageKey = '004MdEUfvAl8eUXeON7NYGhLoQKTKJTKQHdrVuCD.jpg';
        $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/' . $imageKey));
        $image = Image::read($stream);
        $image->resize(150, 150, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(Storage::disk('public')->path('') . $imageKey, quality: 10, progressive: true);
        Storage::disk('s3')->put("thumbs\\" . $imageKey, file_get_contents(Storage::disk('public')->path($imageKey)));
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
    #region Working Functions
    public function streamSave($imageKey, $size = 150)
    {
        $stream = (file_get_contents('https://mkta-portal.s3.us-east-2.amazonaws.com/' . $imageKey));
        $image = Image::read($stream);
        $image->resize($size, $size, function ($constraint) {
            $constraint->aspectRatio();
        });
        $image->save(Storage::disk('public')->path($size . 'x' . $size) . '\\' . $imageKey, quality: 10, progressive: true);
    }

    public function productVerification(Product $product)
    {
        $passPhrase = env('APP_OPEN_KEY');
        if ($passPhrase != $request->passPhrase) {
            return response()->json(['message' => 'Incorrect passphrase.'], 401);
        }
        return response()->json(
            [
                'message' => 'Product Found',
            ], 200);

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
                $products = (array) $product;
                foreach ($products as $key => $prod) {
                    $curProduct = Product::find($prod->id);
                    if ($curProduct) {
                        $curProduct['parent_code'] = $prod['parent_code'];
                        $curProduct['title'] = $prod['title'];
                        $curProduct['description'] = $prod['description'];
                        $curProduct['volume'] = $prod['volume'];
                        $curProduct['weight_net'] = $prod['weight_net'];
                        $curProduct['weight_gross'] = $prod['weight_gross'];
                        $curProduct['dimension_length'] = $prod['dimension_length'];
                        $curProduct['dimension_width'] = $prod['dimension_width'];
                        $curProduct['dimension_height'] = $prod['dimension_height'];
                        $curProduct->save();
                    }
                }
            }

        } catch (\Throwable $th) {
            $msg = $th->getMessage();
            $msgCode = 500;
        } finally {
            return response()->json(['message' => $msg], $msgCode);
        }
    }
    #endregion
}
