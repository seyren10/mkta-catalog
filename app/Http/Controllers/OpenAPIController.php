<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class OpenAPIController extends Controller
{

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
                $product = (array)$product;
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
