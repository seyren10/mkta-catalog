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
            'Creation Group',
            'THE DECOR GROUP, INC.',
            'UNIVERSAL STATUES',
            'MK THEMED ATTRACTIONS AFS',
        ];
        foreach ($arr as $value) {
            CompanyCode::insert([(new CompanyData($value))->toArray()]);
        }

        $arr = [
            'MK DK',
            'MK Ireland',
            'MK UK',
            'MK Austria',
            'MK Canada',
            'MK PH',
            'MK China',
            'MK Korea',
            'MK Sweden',
            'MK Australia',
        ];
        foreach ($arr as $value) {
            CompanyCode::insert([(new CompanyData($value))->toArray()]);
        }

        $arr = [
            'SEASONAL DESIGN LLC',
            'LUXURY STATUE COMPANY',
            'American Christmas LLC',
            'LM TREASURES',
            'CHRISTMAS DESIGNERS',
            'ENVIROLUME',
            'DEC THE MALLS',
            'CHRISTMAS LIGHT DECORATORS',
            'ALL SEASON IMPORTS',
            'K. TZORTZIS-I. THANOS IKE',
            'HOLIDYNAMICS',
            'LONESTAR ELECTRIC',
            'LIFE SIZE MODELS',
            'HOLIDAY BRIGHT LIGHTS',
            'CELEBRATIONS GROUP',
            'MARK ONE VISUAL',
            'HSHL PRODUCTIONS',
            'HOLIDAY SUPPLY',
            'GREAT CHINA ENTERTAINMENT',
            'EPIC ANIMALS',
            'Shenzhen Lesterlighting Technology Co., Ltd',
            'Sydney Zoo'
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
            $newString .= ucfirst(strtolower(trim($sentence))) . ' ';
        }
        return trim($newString);
    }
}
