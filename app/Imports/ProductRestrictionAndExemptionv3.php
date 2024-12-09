<?php

namespace App\Imports;

use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use App\Services\DataImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductRestrictionAndExemptionv3 implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithEvents, WithMultipleSheets
{
    use Importable;
    public function chunkSize(): int
    {
        return 100;
    }
    public function startRow(): int
    {
        return 7;
    }
    #region for Data
    private $filePath;
    private $key;
    public function __construct($filePath, $key)
    {
        $this->filePath = $filePath;
        $this->key = $key;
    }
    private function getSheet($SheetName): Worksheet
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        return $spreadsheet->getSheetByName($SheetName);
    }
    private $curSheet;
    public function sheets(): array
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        $sheetNames = $spreadsheet->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new ProductRestrictionAndExemptionv3($this->filePath, $this->key);
        }
        return $sheets;
    }
    private $rowsValue;
    private $product_access_type_id;
    #endregion
    #region Events
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {

                $curSheet = $event->sheet;
                $curSheet = $this->getSheet($event->sheet->getTitle());
                $this->product_access_type_id = $curSheet->getCell('B1')->getValue();
                $this->rowsValue = self::cellIterator($curSheet, 5);

                $importData = DataImportService::getDataImport('import-product-restriction-and-exception', $this->product_access_type_id, $this->key);
                if ($importData->pass_key != $this->key) {
                    // Pass key is Different
                    // things should update
                    Schema::disableForeignKeyConstraints();
                    ProductRestriction::where('product_access_type_id', $this->product_access_type_id)->delete();
                    ProductExemption::where('product_access_type_id', $this->product_access_type_id)->delete();
                    Schema::enableForeignKeyConstraints();
                    $importData->pass_key = $this->key;
                    $importData->save();
                }

            },
        ];
    }
    #endregion
    public function collection(Collection $rows)
    {
        
    }

    #region Functions
    public function cellIterator(Worksheet $curSheet, $rowNumber): array
    {
        $temp = [];
        foreach ($curSheet->getRowIterator($rowNumber, $rowNumber) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Iterate over all cells, not just those with values
            foreach ($cellIterator as $index => $cell) {
                if ($index == 0) {continue;}
                $temp[] = $cell->getValue(); // Get the cell value and store it
            }
        }
        return $temp;
    }
    #endregion
}
