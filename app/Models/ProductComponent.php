<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComponent extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "is_visible",
        "index",
        "title",
        "value",
        "product_id"
    ];
    protected $hidden = [ "created_at", "updated_at"];

}
