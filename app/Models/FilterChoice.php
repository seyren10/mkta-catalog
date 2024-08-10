<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterChoice extends Model
{
    use HasFactory;
    protected $fillable = ["value", "filter_id"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];
    protected $with = ['filter_choice_products'];

    public function filter_choice_products()
    {
        return $this->hasManyThrough(
            Product::class,
            ProductFilter::class,
            'filter_choice_id',
            'id',
            'id',
            'product_id'
        )->withoutEagerLoads()->with(['product_thumbnail']);;
    }
}
