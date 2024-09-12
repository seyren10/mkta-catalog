<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductExemption;
use App\Models\ProductRestriction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductRestrictionAndExemption implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithEvents, WithMultipleSheets
{
    use Importable, RegistersEventListeners;
    public function chunkSize(): int
    {
        return 1000;
    }
    public function startRow(): int
    {
        return 7;
    }
    #region for Data
    private $filePath;
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
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
            $sheets[$sheetName] = new ProductRestrictionAndExemption($this->filePath);
        }
        return $sheets;
    }
    private $rowsValue;
    private $product_access_type_id;
    #endregion
    #region Events
    public function beforeImport(BeforeImport $event)
    {
        Schema::disableForeignKeyConstraints();
        ProductRestriction::truncate();
        ProductExemption::truncate();
        Schema::enableForeignKeyConstraints();
    }
    public function beforeSheet(BeforeSheet $event)
    {
        $this->curSheet = $event->sheet;
        $this->curSheet = $this->getSheet($event->sheet->getTitle());
        $this->product_access_type_id = $this->curSheet->getCell('B1')->getValue();
        $rowValues = [];
        $rowNumber = 5;
        foreach ($this->curSheet->getRowIterator($rowNumber, $rowNumber) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Iterate over all cells, not just those with values
            foreach ($cellIterator as $cell) {
                $rowValues[] = $cell->getValue(); // Get the cell value and store it
            }
        }
        $this->rowsValue = $rowValues;
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
            ProductRestriction::sync_product_restriction($this->product_access_type_id, $refValue, $Products['restricted']);
            ProductExemption::sync_product_exemption($this->product_access_type_id, $refValue, $Products['exempted']);
        }
    }
}
