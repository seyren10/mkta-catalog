<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductExemption extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_access_type_id",
        "value", 
        "product_id",
    ];
}
