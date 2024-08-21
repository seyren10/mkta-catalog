<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductExemption extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_access_type_id",
        "value", 
        "product_id",
    ];
    public function product_data()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->withOutEagerLoads()->with(['product_thumbnail']);
    }

    public static function sync_product_exemption($PAT, $value, $product_list)
    {
        if( !is_array($product_list) ){
            $product_list = array($product_list);
        }
 
        DB::transaction(function () use ($PAT, $value, $product_list ) {
            // Then, insert new restrictions
            foreach ($product_list as $product) {
                self::create([
                    'product_access_type_id' => $PAT,
                    'value' => $value,
                    'product_id' => $product,
                ]);
            }
        });
    }
}
