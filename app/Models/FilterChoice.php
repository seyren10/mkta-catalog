<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterChoice extends Model
{
    use HasFactory;
    protected $fillable = ["value", "filter_id"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];
    protected $with = [];

}
