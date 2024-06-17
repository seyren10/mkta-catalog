<?php

namespace App\Models;

use App\Models\CompanyCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProductAccessType extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "title", 
        "description",

        "ref_type", 
        "ref_table", 
        "ref_column",

        "source_table", 
        "source_column",

    ];
    protected $hidden = ["created_at", "updated_at", "laravel_through_key"];
}
