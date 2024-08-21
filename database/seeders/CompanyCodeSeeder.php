<?php

namespace Database\Seeders;

use App\Models\CompanyCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CompanyCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        CompanyCode::truncate();
        Schema::enableForeignKeyConstraints();

        $arr = [
            'WINTERLAND INC.',
            'SWISH COLLECTION',
            'THE INTERIOR GALLERY',
            'NLC DECO',
            'HAMAC TRADING COMPANY',
            'THE DECOR GROUP, INC.',
            'UNIVERSAL STATUES',
            'MK THEMED ATTRACTIONS APS',
        ];
        foreach ($arr as $value) {
            CompanyCode::insert([(new CompanyData($value))->toArray()]);
        }
    }
}
class CompanyData
{

    public function __construct(public $title, public $description = '')
    {

    }

    public function toArray()
    {
        return [
            "title" => trim(self::sentenceCase($this->title)),
            "description" => $this->description,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    public function sentenceCase($string)
    {
        $sentences = explode(' ', $string);
        $newString = '';
        foreach ($sentences as $sentence) {
            $newString .= ucfirst(strtolower(trim($sentence))).' ';
        }
        return trim($newString);
    }
}
