<?php
// app/Services/ExampleService.php

namespace App\Services;

use App\Models\DataImport;

class DataImportService
{
    public static function getDataImport($type, $ref_value, $pass_key): DataImport
    {
        $arr = [
            "type" => $type,
            "ref_value" => $ref_value,
            "pass_key" => $pass_key,
        ];
        $conditions = $arr;
        array_pop($conditions);
        return DataImport::firstOrCreate($conditions,$arr);
    }
}
