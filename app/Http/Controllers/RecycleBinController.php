<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class RecycleBinController extends Controller
{
    public function index($type)
    {
        switch ($type) {
            case 'products':
                return response(
                    array(
                        "data" => Product::withOutEagerLoads()->onlyTrashed()->get(),
                    ),
                    200
                );
                break;

            default:
                return response(
                    array(
                        "data" => array(),
                    ),
                    404
                );
                break;
        }
    }
    public function restore(Request $request, $type)
    {
        if (!$request->has('ref_id')) {
            return response(
                array(
                    "data" => "Incorrect Format",
                ),
                401
            );
        }
        switch ($type) {
            case 'products':
                Product::onlyTrashed()->find($request->ref_id)->restore();
                return response(
                    array(
                        "message" => "Product " . $request->ref_id . " has been restored",
                    ),
                    200
                );

                break;

            default:
                return response(
                    array(
                        "data" => array(),
                    ),
                    404
                );
                break;
        }
    }
}
