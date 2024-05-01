<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ["title", "description"];
    protected $hidden = ["created_at", "updated_at"];
    protected $with = ["permissions"];
    
    public function permissions(){ 
        return $this->hasManyThrough( 
            Permission::class, 
            RolePermission::class, 
            'role_id', 
            'id', 
            'id', 
            'permission_id' 
        ); 
    }

}
