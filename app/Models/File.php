<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ["title", "filename", "type"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];

}
