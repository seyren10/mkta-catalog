<?php

namespace App\Exports;

use App\Exports\sheets\FilterSheet;
use App\Models\Filter;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Export_ProductFilter implements WithMultipleSheets
{
    use Exportable;
    public function __construct()
    {
        // Constructor if needed
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function  sheets(): array
    {
        $sheets = [];
        $data = Filter::with(['choices'])->get();
        foreach ($data as $row) {
            $sheets[] = new FilterSheet($row);
        }
        return $sheets;
    }
}
