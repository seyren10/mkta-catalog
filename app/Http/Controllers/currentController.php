<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductAccessResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAccessType;
use Illuminate\Http\Request;

class currentController extends Controller
{
    public static function current(Category $category){
        return  ProductResource::collection(Product::whereHas('product_categories', function ($query) use ($category) {
            if ($category->id) {
                $query->where('product_categories.category_id', $category->id);
            }
        })->paginate(20));
    }
}
