<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "category_id"];
    protected $hidden = ["created_at", "updated_at", "id"];
    public function product_data()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->withOutEagerLoads()->with(['product_thumbnail']);
    }
}
