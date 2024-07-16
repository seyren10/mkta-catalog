<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;
    protected $fillable = ["title", "description", "icon"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];
    protected $with = ['choices'];
    public function choices()
    {
        return $this->hasMany(FilterChoice::class, 'filter_id', 'id');
    }
}
