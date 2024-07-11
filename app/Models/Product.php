<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "parent_code",
        "title",
        "description",
        "volume",
        "weight_net",
        "weight_gross",
        "dimension_length",
        "dimension_width",
        "dimension_height"
    ];
    public $incrementing = false;
    protected $keyType = "string";
    protected $hidden = ["laravel_through_key", 'updated_at'];
    protected $with = ['non_wishlist_users', 'product_images', 'product_components', 'product_categories', 'product_thumbnail', 'related_product', 'recommended_product'];

    public function non_wishlist_users()
    {
        return $this->hasMany(NonWishlistUsers::class, 'product_id', 'id')->without(['product']);
    }

    public function related_product()
    {
        return $this->hasMany(RelatedProduct::class, 'product_id', 'id');
    }
    public function recommended_product()
    {
        return $this->hasMany(RecommendedProduct::class, 'product_id', 'id');
    }

    public function product_thumbnail()
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id')->orderBy('is_thumbnail', 'ASC')->orderBy('index', 'ASC');
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id')->orderBy('is_thumbnail', 'ASC')->orderBy('index', 'ASC');
    }
    public function product_components()
    {
        return $this->hasMany(ProductComponent::class, 'product_id', 'id')->orderBy('index', 'ASC');
    }


    public function product_categories()
    {
        return $this->hasManyThrough(
            Category::class,
            ProductCategory::class,
            'product_id',
            'id',
            'id',
            'category_id'
        )->withOut(["sub_categories", 'file', 'parent_category']);
    }

    public static function variants($product)
    {
        return static::whereNot(function ($query) use ($product) {
            $query->where('id', $product->id);
        })->where('parent_code', $product->parent_code)->get();
    }
}
