<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = ["product_id", "is_thumbnail", "file_id"];
    protected $hidden = [ "created_at", "updated_at"];
    protected $with = ['file'];
    public function file()
    {
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
