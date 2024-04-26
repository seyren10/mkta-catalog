<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        User::insert(
            [
                (new UserData('MKTA Portal System Administrator', 'portal.system.admin@mkthemedattractions.com.ph',1))->toArray(),
                (new UserData('MKTA Customer Profile', 'mktacustomer@mkthemedattractions.com.ph',2))->toArray(),
            ]
        );
    }
}
class UserData
{

    public function __construct(public $name, public $email, public $role_id)
    {
    }

    public function toArray()
    {
        return [

            "name"  => $this->name,
            "email" => $this->email,
            "password"  => Hash::make('password'),
            "is_active" => true,
            "role_id" => 2,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}