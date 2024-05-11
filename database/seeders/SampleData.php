<?php

namespace Database\Seeders;

use App\Models\AreaCode;
use App\Models\CompanyCode;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use App\Models\UserArea;
use App\Models\UserCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AreaCode::insert(
                array(
                    array(
                        "title" => "North US",
                        "description" => "Northern US State"
                    ),
                    array(
                        "title" => "South US",
                        "description" => "Southern US State"
                    )
                )
            );
        CompanyCode::insert(
            array(
                array(
                    "title" => "Interior Gallery",
                    "description" => "Interior Gallery"
                ),
                array(
                    "title" => "American Christmas",
                    "description" => "American Christmas"
                )
            )
        );


        UserArea::insert(
            array(
                array(
                    "area_code_id" => 1,
                    "user_id" => 2
                )
            )
        );

        UserCompany::insert(
            array(
                array(
                    "company_code_id" => 1,
                    "user_id" => 2
                )
            )
        );

        ProductRestriction::insert(
            array(
                array(
                    "product_id" => '2505-0001-1',
                    "value" => 1,
                    "product_access_type_id" => 1,
                ),
                array(
                    "product_id" => '2505-0001',
                    "value" => 1,
                    "product_access_type_id" => 2,
                ),
                array(
                    "product_id" => '2505-0001-2',
                    "value" => 1,
                    "product_access_type_id" => 3,
                )
            )
        );

        ProductExemption::insert(
            array(
                array(
                    "product_id" => '2505-0001-1',
                    "value" => 1,
                    "product_access_type_id" => 3,
                )
            )
        );
    }
}
