<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class ProductFilter extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "filter_id", "filter_choice_id"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];

    public function filter()
    {
        return $this->hasOne(Filter::class);
    }

    public static function sync_product_filters($FilterID, $optionID, $product_list)
    {
        $product_list = is_array($product_list) ? $product_list : array($product_list);
        $product_list = collect(Product::whereIn('id', $product_list)->withOutEagerLoads()->get())->pluck('id');
        $temp = array_map(
            function($productId) use ($FilterID, $optionID) {
            return [
                'filter_id' => $FilterID,
                'filter_choice_id' => $optionID,
                'product_id' => $productId,
            ];
        }, $product_list->toArray() );
        $temp = [];
        ProductFilter::insert($temp);
    }
}
