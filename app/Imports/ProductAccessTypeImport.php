<?php

namespace App\Imports;

use App\Models\ProductAccessType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductAccessTypeImport implements ToModel, WithBatchInserts, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ProductAccessType([
            "type" => $row['type'],
            "title" => $row['title'],
            "description" => $row['description'],
            "ref_type" => $row['ref_type'],
            "ref_table" => $row['ref_table'],
            "ref_column" => $row['ref_column'],
            "display_column" => $row['display_column'],
            "source_table" => $row['source_table'],
            "source_column" => $row['source_column']
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
