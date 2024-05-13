<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();
        Role::insert(
            [
                (new RoleData('System Administrator',null))->toArray(),
                (new RoleData('Customer',null))->toArray(),
            ]
        );
    }
}
class RoleData
{

    public function __construct(public $title, public $desc)
    {
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->desc,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
