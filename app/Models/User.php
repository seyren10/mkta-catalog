<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [ 'name', 'email', 'password', ];
    protected $hidden = [ 'password', 'remember_token', ];
    protected $with = ['permissions'];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function permissions(){ 
        return $this->hasManyThrough( 
            Permission::class, 
            UserPermission::class, 
            'user_id', 
            'id', 
            'id', 
            'permission_id' 
        ); 
    }
    public function role_permissions(){ 
        return $this->hasManyThrough( 
            Permission::class, 
            UserPermission::class, 
            'user_id', 
            'id', 
            'id', 
            'permission_id' 
        ); 
    }

}
