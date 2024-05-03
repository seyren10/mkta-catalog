<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = "string";
    protected $hidden = ["laravel_through_key", 'udpated_at'];
    protected $with = ['non_wishlist_users', 'product_images', 'product_components'];

    public function non_wishlist_users()
    {
        return $this->hasMany(NonWishlistUsers::class, 'product_id', 'id');
    }
    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->orderBy('is_thumbnail', 'ASC');
    }
    public function product_components()
    {
        return $this->hasMany(ProductComponent::class, 'product_id', 'id')->orderBy('index', 'ASC');
    }
}
