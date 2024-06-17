<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ["title", "description", 'parent_id', 'file_id'];
    protected $hidden = ["created_at", "updated_at", 'laravel_through_key'];
    protected $with = ["sub_categories", 'file', 'parent_category'];
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
    public function parent_category()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id')->without($this->with);
    }
    public function sub_categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->without(['parent_category']);
    }
}
