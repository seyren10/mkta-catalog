<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();
        Permission::insert(
            [
                (new PermissionData('admin-dashboard','Admin Dashboard','Allow the user to access Admin Dashboard'))->toArray(),
                (new PermissionData('customer-wishlist','Customer Wishlist', 'Allow the user to access his Customer Wishlist'))->toArray(),
            ]
        );
    }
}
class PermissionData
{

    public function __construct(public $key, public $title, public $description)
    {
    }

    public function toArray()
    {
        return [
            "key"  => $this->key,
            "title"  => $this->title,
            "description" => $this->description,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
