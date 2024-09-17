<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductAccessResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAccessType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class currentController extends Controller
{
    public static function current(){
        return response(
            array(
                "time" => Carbon::now()
            ), 
            200
        );
    }
}
