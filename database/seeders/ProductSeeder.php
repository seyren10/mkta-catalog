<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();
        Product::insert(
            [
                array(
                    "id"                => "2505-0001" ,
                    "parent_code"       => null ,
                    "title"             => "Santa Chair (Gold/Red)" ,
                    "description"       => "Santa Chair" ,
                    "volume"            => 0.0 ,
                    "weight_net"        => 0.0 ,
                    "weight_gross"      => 0.0 ,
                    "dimension_length"  => 0.0 ,
                    "dimension_width"   => 0.0 ,
                    "dimension_height"  => 0.0 ,
                ),
                array(
                    "id"                => "2505-0001-1" ,
                    "parent_code"       => null ,
                    "title"             => "Santa Chair (White/Silver)" ,
                    "description"       => "Santa Chair" ,
                    "volume"            => 0.0 ,
                    "weight_net"        => 0.0 ,
                    "weight_gross"      => 0.0 ,
                    "dimension_length"  => 0.0 ,
                    "dimension_width"   => 0.0 ,
                    "dimension_height"  => 0.0 ,
                ),
                array(
                    "id"                => "2505-0001-2" ,
                    "parent_code"       => null ,
                    "title"             => "Santa Chair (Blue/White)" ,
                    "description"       => "Santa Chair" ,
                    "volume"            => 0.0 ,
                    "weight_net"        => 0.0 ,
                    "weight_gross"      => 0.0 ,
                    "dimension_length"  => 0.0 ,
                    "dimension_width"   => 0.0 ,
                    "dimension_height"  => 0.0 ,
                ),
            ]
        );
    }
}
