<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilter extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "filter_id", "filter_choice_id"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];

}
