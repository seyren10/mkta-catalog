<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWishlist extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "user_id"];
    protected $hidden = ["id", "created_at", "updated_at"];
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')
            ->select('id', 'title', 'description')
            ->withOut(
                [
                    'non_wishlist_users',
                    'product_images',
                    'product_components',
                    'product_categories'
                ]
            );
    }
}
