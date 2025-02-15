<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompressImage extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'image_key',
        'image_size',
        'status', // Enum : ['pending', 'ongoing', 'done', 'error'] 
    ];



}
