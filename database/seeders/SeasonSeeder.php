<?php

namespace Database\Seeders;

use App\Models\Season;
use App\Models\SeasonCategory;
use Illuminate\Database\Seeder;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Season::insert(
            array(
                "title" => 'Christmas Collection',
                "description" => 'Seasons Product',
                "start_month" => 8,
                "start_date" => 1,
                "end_month" => 12,
                "end_date" => 31
            )
        );
        foreach ([2,3,4] as $key => $value) {
            SeasonCategory::insert(
                array(
                    "season_id" => 1,
                    "category_id" => $value
                )
            );
        }
        
    }
}
