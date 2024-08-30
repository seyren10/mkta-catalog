<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;

class CategoryImport implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithMultipleSheets, WithEvents
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
    #region for Category Data
    private $filePath;
    private $id;
    private $title;
    private $description;
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
    public function sheets(): array
    {
        $sheetNames = $this->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new CategoryImport($this->filePath);
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
                $this->id = $event->sheet->getCell('A2');
                $this->title = $event->sheet->getCell('C2');
                $this->description = $event->sheet->getCell('D2');
            },
        ];
    }
    #endregion
    public function collection(Collection $rows)
    {
        $curCategory = Category::find($this->id);
        if ($curCategory === null) { 
            return;
        }
        $curCategory->title = $this->title ?? $curCategory->title;
        $curCategory->description = $this->description ?? $curCategory->description;
        $curCategory->save();

        $products = [];
        foreach ($rows as $rowIndex => $row) {
            array_push($products, $row[0]);
        }
        $products = collect(Product::whereIn('id', $products)->get())->pluck('id');
        $curCategory->sync_product()->sync($products);
    }

}
