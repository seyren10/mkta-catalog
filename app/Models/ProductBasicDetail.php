<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBasicDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "parent_code",
        "title",
        "description",
        "volume",
        "weight_net",
        "weight_gross",
        "dimension_length",
        "dimension_width",
        "dimension_height"
    ];
}
