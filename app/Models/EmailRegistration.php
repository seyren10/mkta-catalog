<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'company',
        'region',
        'comment'
    ];
}
