<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempImageUpload extends Model
{
    use HasFactory;

    protected $fillable = ["product_id", "json"];
    protected $hidden = [ "created_at", "updated_at"];

    protected $casts = [
        'json' => 'array',
    ];
}
