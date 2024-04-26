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
                (new ProductAccessTypeData('area-code','Area Code', 'Allow or Deny access to a user in certain Area Code'))->toArray(),
                (new ProductAccessTypeData('company-code', 'Company Code', 'Allow or Deny access to a user in a certain Company Code'))->toArray(),
                (new ProductAccessTypeData('customer', 'Customer', 'Allow or Deny access to a certain user'))->toArray(),
            ]
        );
    }
}
class ProductAccessTypeData
{

    public function __construct(public $type, public $title, public $desc)
    {
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->desc,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}