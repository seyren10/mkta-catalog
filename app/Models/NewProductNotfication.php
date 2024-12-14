<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProductNotfication extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'product_id'];
}
