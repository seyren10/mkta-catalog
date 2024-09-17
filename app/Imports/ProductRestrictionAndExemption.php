<?php

namespace App\Imports;

use App\Models\Product;
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

class ProductRestrictionAndExemption implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithEvents, WithMultipleSheets
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
            $sheets[$sheetName] = new ProductRestrictionAndExemption($this->filePath, $this->key);
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

        $formattedRows = [];
        foreach ($rows as $key => $row) {
            $product_id = "";
            foreach ($row as $cellIndex => $cell) {
                $refValue = $this->rowsValue[$cellIndex];
                $keyExist = array_key_exists($refValue, $formattedRows);
                if (!$keyExist) {
                    $formattedRows[$refValue] = array(
                        'restricted' => [],
                        'exempted' => []
                    );
                }
                if ($cellIndex == 0) {
                    $product_id = $cell;
                    continue;
                }
                if (in_array(trim(strtolower($cell)), ['yes', 'true'])) {
                    $formattedRows[$refValue]['restricted'] = [ ...$formattedRows[$refValue]['restricted'], $product_id];
                }
                if (in_array(trim(strtolower($cell)), ['no', 'false'])) {
                    $formattedRows[$refValue]['exempted'] = [ ...$formattedRows[$refValue]['exempted'], $product_id];
                }
            }
        }
        $ProductList = array_keys($formattedRows);
        $ProductList = collect(Product::whereIn('id', $ProductList)->get())->pluck('id')->toArray();

        foreach ($formattedRows as $refValue => $Products) {

            if ($refValue == '') {continue;}
            
            $cur_PAT = $this->product_access_type_id;
            $temp = array_map(
                function ($productId) use ($refValue, $cur_PAT) {
                    return [
                        "product_access_type_id" => $cur_PAT,
                        "value" => $refValue,
                        'product_id' => $productId,
                    ];
                }, $Products['restricted']);
            ProductRestriction::insert($temp);

            $temp = array_map(
                function ($productId) use ($refValue, $cur_PAT) {
                    return [
                        "product_access_type_id" => $cur_PAT,
                        "value" => $refValue,
                        'product_id' => $productId,
                    ];
                }, $Products['exempted']);
            ProductExemption::insert($temp);
        }

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
