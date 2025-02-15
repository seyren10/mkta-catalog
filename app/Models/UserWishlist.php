<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "user_id", "qty"];
    protected $hidden   = ["created_at", "updated_at"];
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            // ->withOut(
            //     [
            //         'non_wishlist_users',
            //         'product_images',
            //         'product_components',
            //         'product_categories',
            //     ]
            // )
            ->withoutEagerLoads()->with('product_thumbnail');
    }
}
