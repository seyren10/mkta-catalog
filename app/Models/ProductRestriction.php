<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductRestriction extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_access_type_id",
        "value",
        "product_id",
    ];

    public function data($table)
    {
        return DB::table($table)
            ->where('id', $this->value)
            ->get();
    }

}
