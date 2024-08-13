<?php

namespace App\Models;

use App\Models\FilterChoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFilter extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "filter_id", "filter_choice_id"];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];

    public function filter()
    {
        return $this->hasOne(Filter::class);
    }

    
    
}
