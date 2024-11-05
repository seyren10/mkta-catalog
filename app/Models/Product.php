<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;
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
    protected $with = ['non_wishlist_users', 'product_images', 'product_components', 'product_categories', 'product_thumbnail', 'related_product', 'recommended_product', 'product_filter', 'variants'];
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
    public function product_filter()
    {
        return $this->hasMany(ProductFilter::class, 'product_id', 'id')
            ->select(['*', DB::raw('CONCAT(filter_id,"-",filter_choice_id) AS filter_key')]);
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
        )->distinct('category_id')->orderBy('category_id','ASC')->withOutEagerLoads();
    }

    public function productFilters()
    {
        return $this->hasMany(ProductFilter::class);
    }
    
    public function filterChoices()
    {
        return $this->belongsToMany(FilterChoice::class, 'product_filters', 'product_id', 'filter_choice_id');
    }

    public function variants()
    {
        return $this->hasMany(Product::class,'parent_code', 'parent_code')->withOutEagerLoads();


        // return static::whereNot(function ($query) use ($product) {
        //     $query->where('id', $product->id);
        // })->where('parent_code', $product->parent_code)->get();
    }
    
    public function sync_product_categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }
    
    public function sync_related_products(){
        return $this->belongsToMany(RelatedProduct::class, 'related_products', 'product_id', 'related_product_id');
    }
    public function sync_recommended_products(){
        return $this->belongsToMany(RecommendedProduct::class, 'recommended_products', 'product_id', 'recommended_product_id');
    }

}
