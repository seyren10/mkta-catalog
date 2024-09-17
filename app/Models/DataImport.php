<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataImport extends Model
{
    use HasFactory;
    protected $fillable = ["type", "ref_value", "pass_key"];
    protected $hidden = ["created_at", "updated_at"];

    

}
