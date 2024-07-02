<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ["title", "filename", "type"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];

}
