<?php

namespace Database\Seeders;

use App\Models\AreaCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AreaCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        AreaCode::truncate();
        Schema::enableForeignKeyConstraints();

        $arr = array(
            array(
                "title" => "Rest of the World",
                "description" => "Rest of the World",
            ),
            array(
                "title" => "US",
                "description" => "US",
            ),
            array(
                "title" => "Europe",
                "description" => "Europe",
            ),

        );
        foreach ($arr as $key => $value) {AreaCode::create($value);}

    }
}
