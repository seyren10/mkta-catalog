<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAccessType extends Model
{
    use HasFactory;
    protected $fillable = [
        "key",
        "title", 
        "description",

        "ref_type", 
        "ref_table", 
        "ref_column",
    ];
    protected $hidden = ["created_at", "updated_at", "laravel_through_key"];

}
