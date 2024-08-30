<?php

namespace App\Imports;

use App\Models\Filter;
use App\Models\FilterChoice;
use App\Models\ProductFilter;
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
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductFilters implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithEvents, WithMultipleSheets
{

    use Importable, RegistersEventListeners;
    public function chunkSize(): int
    {
        return 1000;
    }
    public function startRow(): int
    {
        return 8;
    }

    #region for Data
    private $filePath;
    private $curSheet;
    private $rowData = 6;
    private $optionID;
    private $optionText;
    private $primary_id;
    private $primary_data = [
        'title' => '',
        'description' => '',
        'icon' => '',
    ];
    #region Functions
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
    private function getSheet($SheetName): Worksheet
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        return $spreadsheet->getSheetByName($SheetName);
    }
    public function sheets(): array
    {
        Log::info("sheets");
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        $sheetNames = $spreadsheet->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new ProductFilters($this->filePath);
        }
        return $sheets;
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->curSheet = $event->sheet;
                $this->curSheet = $this->getSheet($event->sheet->getTitle());
                $this->primary_id = $this->curSheet->getCell('B1')->getValue();
                $rowValues = [];
                foreach ($this->curSheet->getRowIterator($this->rowData, $this->rowData) as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Iterate over all cells, not just those with values
                    foreach ($cellIterator as $cell) {
                        $rowValues[] = $cell->getValue(); // Get the cell value and store it
                    }
                }
                $this->optionID = $rowValues;

                $rowValues = [];
                foreach ($this->curSheet->getRowIterator($this->rowData + 1, $this->rowData + 1) as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false); // Iterate over all cells, not just those with values
                    foreach ($cellIterator as $cell) {
                        $rowValues[] = $cell->getValue(); // Get the cell value and store it
                    }
                }
                $this->optionText = $rowValues;

            },
        ];
    }
    #endregion
    #endregion
    public function collection(Collection $rows)
    {

        $formattedRows = [];
        $curFilter = Filter::find($this->primary_id);
        if ($curFilter == null) {
            $curFilter = Filter::create($this->primary_data);
        }

        foreach ($rows as $rowIndex => $row) {
            $product_id = "";
            foreach ($row as $cellIndex => $cell) {
                if ($cellIndex == 0) {
                    $product_id = $cell;
                    continue;
                }
                #region Setting Up the Option
                Log::info('CellText:'.$this->optionText[$cellIndex]);
                $optionID = $this->optionID[$cellIndex] ?? -1;
                if ($optionID == -1) {
                    $optionData = FilterChoice::create(array(
                        "value" => $this->optionText[$cellIndex],
                        "filter_id" => $curFilter->id,
                    ));
                    $optionID = $optionData->id;
                    $this->optionID[$cellIndex] = $optionID;
                } else {
                    $optionData = FilterChoice::find($optionID);
                    $optionData->value = $this->optionText[$cellIndex];
                    $optionData->save();
                }
                #endregion

                $keyExist = array_key_exists($optionID, $formattedRows);
                if (!$keyExist) {
                    $formattedRows[$optionID] = [];
                }

                if (in_array(trim(strtolower($cell)), ['yes', 'true'])) {
                    $formattedRows[$optionID] = [...$formattedRows[$optionID], $product_id];
                }
            }

        }
        foreach ($formattedRows as $optionID => $products) {
            if ($optionID == '') {continue;}
            ProductFilter::sync_product_filters($curFilter->id, $optionID, $products);
        }
    }

}
