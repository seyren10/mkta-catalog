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
        if (!is_array($product_list)) {
            $product_list = array($product_list);
        }
        $product_list = collect(Product::whereIn('id', $product_list)->withOutEagerLoads()->get())->pluck('id');
        $isValid = ProductAccessType::find($PAT);
        // Proceed if there are products in the list
        if ($product_list->isNotEmpty() && $isValid != null) {
            // Delete existing exemptions for the specified PAT and value
            self::where([
                ['product_access_type_id', '=', $PAT],
                ['value', '=', $value],
            ])->delete();

            // Use a transaction to ensure atomicity of insertions
            DB::transaction(function () use ($PAT, $value, $product_list) {
                foreach ($product_list as $product_id) {
                    self::create([
                        'product_access_type_id' => $PAT,
                        'value' => $value,
                        'product_id' => $product_id,
                    ]);
                }
            });
        }
    }
}
