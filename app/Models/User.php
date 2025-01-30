<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Find it on the Illuminate Database Eloquent Builder.php
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'role_id',
        'first_time_login',
        'broker_company_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'email_verified_at',
        'password',
        'remember_token',
    ];
    protected $with = [
        'role_data',
        'permissions',
        'role_permissions',
        'user_areas',
        'user_companies',
        'non_wishlist_products',
        'wishlist_products',
        'broker_company',
    ];
    /*
            remove eager loaded relation invoked by $with using ->withoutEagerLoads() or ->without(['relations'])
    */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'first_time_login'  => 'boolean',
        ];
    }
    public function non_wishlist_products()
    {
        return $this->hasManyThrough(
            Product::class,
            NonWishlistUsers::class,
            'user_id',
            'id',
            'id',
            'product_id'
        )->withoutEagerLoads()->with(['product_thumbnail']);
    }
    public function user_areas()
    {
        return $this->hasManyThrough(
            AreaCode::class,
            UserArea::class,
            'user_id',
            'id',
            'id',
            'area_code_id'
        );
    }
    public function user_companies()
    {
        return $this->hasManyThrough(
            CompanyCode::class,
            UserCompany::class,
            'user_id',
            'id',
            'id',
            'company_code_id'
        );
    }
    public function role_data()
    {

        return $this->hasOne(Role::class, 'id', 'role_id')->withoutEagerLoads();
    }
    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            UserPermission::class,
            'user_id',
            'id',
            'id',
            'permission_id'
        );
    }
    public function role_permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'role_id',
            'id',
            'role_id',
            'permission_id'
        );
    }
    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wishlist_products()
    {
        return $this->hasMany(UserWishlist::class, 'user_id', 'id')->with('product');
    }
    // public function wishlist_products()
    // {
    //     return $this->hasManyThrough(
    //         Product::class,
    //         UserWishlist::class,
    //         'user_id',
    //         'id',
    //         'id',
    //         'product_id'
    //     )->withoutEagerLoads()->with(['product_thumbnail']);
    // }

    public function wishlists()
    {
        return $this->hasMany(UserWishlist::class);
    }
    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function broker_company()
    {
        return $this->belongsTo(CompanyCode::class, 'broker_company_id', 'id');
    }
}
