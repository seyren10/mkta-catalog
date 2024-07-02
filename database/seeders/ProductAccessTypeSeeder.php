<?php

namespace Database\Seeders;

use App\Models\ProductAccessType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductAccessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        ProductAccessType::truncate();
        Schema::enableForeignKeyConstraints();
        ProductAccessType::insert(
            [
                (new ProductAccessTypeData(
                                        'area-code',
                                        'Area Code', 
                                        'Allow or Deny access to a user in certain Area Code',
                                        'indirect',
                                        'user_areas',
                                        'area_code_id',
                                        'area_codes',
                                        'title'
                                        ))->toArray(),
                (new ProductAccessTypeData(
                                        'company-code', 
                                        'Company Code', 
                                        'Allow or Deny access to a user in a certain Company Code',
                                        'indirect',
                                        'user_companies',
                                        'company_code_id',
                                        'company_codes',
                                        'title'
                                        ))->toArray(),
                (new ProductAccessTypeData(
                                        'customer', 
                                        'Customer', 
                                        'Allow or Deny access to a certain user',
                                        'direct',
                                        'users',
                                        'id',
                                        'users',
                                        'name'
                                        ))->toArray(),
            ]
        );
    }
}
class ProductAccessTypeData
{

    public function __construct(
        public $type, 
        public $title, 
        public $desc, 

        public $ref_type,
        public $ref_table,
        public $ref_column,
        public $source_table,
        public $source_column,
        )
    {
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->desc,
            "ref_type" => $this->ref_type,
            "ref_table" => $this->ref_table,
            "ref_column" => $this->ref_column,
            "source_table" => $this->source_table,
            "source_column" => $this->source_column,
            "display_column" => $this->source_column,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}