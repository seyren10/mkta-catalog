<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductImport implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            "id" => $row['id'],
            "parent_code" => $row['parent_code'],
            "title" => $row['title'],
            "description" => $row['description'],
            "volume" => $row['volume'],
            "weight_net" => $row['weight_net'],
            "weight_gross" => $row['weight_gross'],
            "dimension_length" => $row['dimension_length'],
            "dimension_width" => $row['dimension_width'],
            "dimension_height" => $row['dimension_height']
        ]);
    }


    public function batchSize(): int
    {
        return 300;
    }

    public function chunkSize(): int
    {
        return 300;
    }
}
