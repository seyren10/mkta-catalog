<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;

class RelatedAndRecommendedProducts implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithMultipleSheets, WithEvents
{

    use Importable, RegistersEventListeners;
    public function chunkSize(): int
    {
        return 10000;
    }
    public function startRow(): int
    {
        return 2;
    }
    #region for Data
    private $filePath;
    private $product_id;
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
    public function sheets(): array
    {
        $sheetNames = $this->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new RelatedAndRecommendedProducts($this->filePath);
        }
        return $sheets;
    }
    private function getSheetNames(): array
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        return $spreadsheet->getSheetNames();
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->product_id = $event->sheet->getTitle();
            },
        ];
    }
    #endregion
    public function collection(Collection $rows)
    {
        $curProduct = Product::find($this->product_id);
        if ($curProduct === null) {
            return;
        }
        $related = [];
        $recommended = [];
        foreach ($rows as $key => $row) {
            array_push($related, $row[0]);
            array_push($recommended, $row[1]);
        }

        $related = collect(Product::whereIn('id', $related)->get())->pluck('id');
        $recommended = collect(Product::whereIn('id', $recommended)->get())->pluck('id');

        $curProduct->sync_related_products()->sync($related);
        $curProduct->sync_recommended_products()->sync($recommended);
    }

}
