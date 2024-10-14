<?php

namespace App\Imports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
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
        $rows
            ->map(function ($row) {
                $data = [
                    'id' => $this->filterValue($row[0]),
                    'parent_code' => $this->filterValue($row[1], $row[0]),
                    'title' => $this->filterValue($row[2], ' '),
                    'description' => $this->filterValue($row[3], ' '),
                    'volume' => $this->filterValue($row[4], 0),
                    'weight_net' => $this->filterValue($row[5], 0),
                    'weight_gross' => $this->filterValue($row[6], 0),
                    'dimension_length' => $this->filterValue($row[7], 0),
                    'dimension_width' => $this->filterValue($row[8], 0),
                    'dimension_height' => $this->filterValue($row[9], 0),
                ];
                return $data;
            })
            ->each(function ($row) {
                Product::upsert(
                    $row,
                    uniqueBy: [
                        'id',
                    ],
                    update: [
                        'parent_code',
                        'title',
                        'description',
                        'volume',
                        'weight_net',
                        'weight_gross',
                        'dimension_length',
                        'dimension_width',
                        'dimension_height',
                    ]
                );
            });
    }
    private function filterValue($value, $default = '')
    {
        return !is_null($value) && trim($value) !== '' ? $value : $default;
    }
}
