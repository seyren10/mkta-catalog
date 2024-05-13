<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonWishlistUsers extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "user_id"];
    protected $hidden = ["id", "created_at", "updated_at"];
}
