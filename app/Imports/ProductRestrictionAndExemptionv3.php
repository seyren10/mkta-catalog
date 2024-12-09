<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use App\Services\DataImportService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductRestrictionAndExemptionv3 implements ToCollection, WithStartRow, WithEvents, WithMultipleSheets
{
    use Importable;
    public function startRow(): int
    {
        return 2;
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
    #endregion
    #region Events
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $importData = DataImportService::getDataImport('import-product-restriction-and-exception', "", $this->key);
                if ($importData->pass_key != $this->key) {
                    $importData->pass_key = $this->key;
                    $importData->save();
                }

            },
        ];
    }
    #endregion
    public function collection(Collection $rows)
    {
        $Products = Product::get()->pluck('id')->toArray();
        $restricted = collect();
        $exempted = collect();
        $missingProducts = collect([]);
        foreach ($rows as $row) {
            $productID = $row[0];
            // Removing the first column (productID)
            $temp = array_slice($row->toArray(), 1);
            // Chunk the remaining values into pairs
            $chunks = array_chunk($temp, 2);
            if (!in_array($productID, $Products)) {
                $missingProducts->push($productID);
                // continue;
            }
            // Schema::disableForeignKeyConstraints();
            foreach ($chunks as $key => $chunk) {
                if ($chunk[0] != null) {
                    $tempData = [
                        "product_access_type_id" => $key + 1,
                        "value" => ($chunk[0] !== 'All') ? $chunk[0] : 0,
                        "product_id" => $productID,
                    ];
                    // ProductExemption::create($tempData);
                    $exempted->push($tempData);
                }
                if ($chunk[1] != null) {
                    $tempData = [
                        "product_access_type_id" => $key + 1,
                        "value" => ($chunk[1] !== 'All') ? $chunk[1] : 0,
                        "product_id" => $productID,
                    ];
                    // ProductRestriction::create($tempData);
                    $restricted->push($tempData);
                }
            }
            // Schema::enableForeignKeyConstraints();
        }
        // Log::info($restricted->chunk(200)->toArray());
        // Insert the restricted and exempted data in chunks of 100
        Log::info($missingProducts->toArray());
        // return;
        Schema::disableForeignKeyConstraints();
        $restricted->chunk(200)->map(function ($allData) {
           ProductRestriction::insert($allData->toArray()); 
        });
        $exempted->chunk(200)->map(function ($allData) {
           ProductExemption::insert($allData->toArray()); 
        });
        Schema::enableForeignKeyConstraints();
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
