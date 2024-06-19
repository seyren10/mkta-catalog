<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonWishlistUsers extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "user_id"];
    protected $hidden = ["id", "created_at", "updated_at"];
    protected $with = ['user', 'product'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select('id', 'name', 'email')->withOut(['role_data','permissions','role_permissions','user_areas','user_companies','non_wishlist_products',
        ]);
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->select('id','title', 'description')->withOut(['non_wishlist_users', 'product_images', 'product_components', 'product_categories']);
    }
}
