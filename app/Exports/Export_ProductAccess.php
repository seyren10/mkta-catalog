<?php

namespace App\Exports;

use App\Exports\Sheets\PATSheet;
use App\Models\Filter;
use App\Models\ProductAccessType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Export_ProductAccess implements WithMultipleSheets,ShouldQueue
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
        $data = ProductAccessType::get();
        foreach ($data as $row) {

            $curData = $row;
            $sourceData = DB::table($row['source_table'])
                    ->select(['id', $row['source_column']])
                    ->get();
            $curData['source_table'] = $sourceData;
            $sheets[] = new PATSheet($curData);
        }
        return $sheets;
    } 
}
