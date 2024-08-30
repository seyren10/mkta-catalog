<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ["title", "description", 'parent_id', 'file_id', "cover_html"];

    protected $hidden = ["created_at", "updated_at", 'laravel_through_key', 'banner_file_id', 'cover_html'];
    protected $with = ["sub_categories", 'file', 'parent_category', 'bannerFile', 'products'];

    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }

    public function bannerFile()
    {
        return $this->hasOne(File::class, 'id', 'banner_file_id');
    }

    public function parent_category()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')->without($this->with);
    }
    public function sub_categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->without(['parent_category']);
    }

    public function products()
    {
        return $this->hasMany(ProductCategory::class, 'category_id', 'id')->with('product_data');
    }

    public function sync_product()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}
