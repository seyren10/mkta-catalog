<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\FilterChoice;
use App\Models\Product;
use App\Models\ProductFilter;
use Illuminate\Support\Facades\DB;

class ProductFilterController extends Controller
{
    public function store(Product $product, Filter $filter, FilterChoice $filter_choice)
    {
        ProductFilter::create(
            array(
                'product_id' => $product->id,
                'filter_id' => $filter->id,
                'filter_choice_id' => $filter_choice->id,
            )
        );
        return response()->noContent();
    }
    public function show(Product $product)
    {
        $collect = ProductFilter::where('product_id', $product->id)->select(['*', DB::raw('CONCAT(filter_id,"-",filter_choice_id) AS filter_key')])->get();
        return response(array("data"=>collect($collect)->pluck('filter_key')));
    }
    public function destroy(Product $product, Filter $filter, FilterChoice $filter_choice)
    {
        ProductFilter::where('product_id', $product->id)
            ->where('filter_id', $filter->id)
            ->where('filter_choice_id', $filter_choice->id)
            ->delete();
        return response()->noContent();
    }
}
