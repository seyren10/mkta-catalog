<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToCollection, WithChunkReading, ShouldQueue, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            $data = [
                'id' => $row[0],
                'parent_code' => $this->filterValue($row[1]),
                'title' => $this->filterValue($row[2]),
                'description' => $this->filterValue($row[3]),
                'volume' => $this->filterValue($row[4]),
                'weight_net' => $this->filterValue($row[5]),
                'weight_gross' => $this->filterValue($row[6]),
                'dimension_length' => $this->filterValue($row[7]),
                'dimension_width' => $this->filterValue($row[8]),
                'dimension_height' => $this->filterValue($row[9]),
            ];
            $data = array_filter($data, function ($value) { return !is_null($value) && trim($value) !== ''; });
            $curProduct = Product::find( $data['id'] );
            if ($curProduct === null) { continue; }
            foreach ($data as $col => $value ) { $curProduct[$col] = $value; }
            $curProduct->save();
        }
    }
    private function filterValue($value)
    {
        return !is_null($value) && trim($value) !== '' ? $value : null;
    }
}
