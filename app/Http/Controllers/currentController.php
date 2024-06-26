<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductAccessResource;
use App\Models\ProductAccessType;
use Illuminate\Http\Request;

class currentController extends Controller
{
    public static function current(Request $request){
        return new ProductAccessResource(ProductAccessType::where('id', $request->id)->get()->first());
    }
}
