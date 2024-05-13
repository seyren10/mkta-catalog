<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        RolePermission::truncate();
        Schema::enableForeignKeyConstraints();
        RolePermission::insert(
            [
                array('role_id'=>1,"permission_id"=>1),
                array('role_id'=>1,"permission_id"=>2)
            ]
        );
    }
}
