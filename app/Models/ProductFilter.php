<?php

namespace App\Models;

use App\Models\FilterChoice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductFilter extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "filter_id", "filter_choice_id"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];

    public function filter()
    {
        return $this->hasOne(Filter::class);
    }

    
    public static function sync_product_filters($FilterID, $optionID, $product_list){

        if (!is_array($product_list)) {
            $product_list = array($product_list);
        }
        $product_list = collect(Product::whereIn('id', $product_list)->withOutEagerLoads()->get())->pluck('id');
        $isValid = Filter::find($FilterID);
        // Proceed if there are products in the list
        if ($product_list->isNotEmpty() && $isValid != null) {
            // Delete existing restrictions for the specified PAT and value
            // Use a transaction to ensure atomicity of insertions
            DB::transaction(function () use ($FilterID, $optionID, $product_list) {
                foreach ($product_list as $product_id) {
                    self::where([
                        ['filter_id', '=', $FilterID],
                        ['product_id', '=', $product_id],
                    ])->delete(); 
                    self::create([
                        'filter_id' => $FilterID,
                        'filter_choice_id' => $optionID,
                        'product_id' => $product_id,
                    ]);
                }
            });
        }

    }
}
