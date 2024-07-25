<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'type',
        'notifiable',
        'data',
        'read_at',
    ];
    protected $hidden = [
        "updated_at",
        // "type",
        "notifiable_type",
        "notifiable_id",
    ];
    protected $with = [];

}
