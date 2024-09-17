<?php

namespace App\Imports;

use App\Models\Filter;
use App\Models\FilterChoice;
use App\Models\ProductFilter;
use App\Services\DataImportService;
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
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class ProductFilters implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithEvents, WithMultipleSheets
{

    use Importable, RegistersEventListeners;
    public function chunkSize(): int
    {
        return 100;
    }
    public function startRow(): int
    {
        return 8;
    }
    #region for Data
    private $key;
    private $filePath;
    private $optionID = [];
    private $primary_id;
    #region Functions
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
    public function sheets(): array
    {
        Log::info("sheets");
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        $sheetNames = $spreadsheet->getSheetNames();
        $sheets = [];

        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new ProductFilters($this->filePath, $this->key);
        }
        return $sheets;
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $curSheet = $event->sheet;
                $curSheet = $this->getSheet($event->sheet->getTitle());
                $data = self::get_Filter(
                    $curSheet->getCell('B2')->getValue(),
                    $curSheet->getCell('B3')->getValue(),
                    $curSheet->getCell('B4')->getValue(),
                    $curSheet->getCell('B1')->getValue()
                );
                $this->primary_id = $data->id;

                $importData = DataImportService::getDataImport('import-product-filters', $this->primary_id, $this->key);
                if( $importData->pass_key != $this->key ){
                    // Pass key is Different
                    // things should update
                    Schema::disableForeignKeyConstraints();
                    ProductFilter::where('filter_id', $this->primary_id)->delete();
                    Schema::enableForeignKeyConstraints();
                    $importData->pass_key = $this->key;
                    $importData->save();
                }

                $temp_optionID = self::cellIterator($curSheet, 6);
                array_shift($temp_optionID);

                $tempList = self::cellIterator($curSheet, 7);
                array_shift($tempList);

                foreach ($tempList as $key => $value) {
                    $temp_data = self::get_Option(
                        $this->primary_id,
                        $value,
                        $temp_optionID[$key] ?? -1);
                    $this->optionID[] = $temp_data->id;
                }
            },
        ];
    }
    #endregion
    #endregion
    public function collection(Collection $rows)
    {
        $formattedRows = [];
        foreach ($rows as $rowIndex => $row) {
            $product_id = "";
            foreach ($row as $cellIndex => $cell) {
                if ($cellIndex == 0) {
                    $product_id = $cell;
                    continue;
                }
                $optionID = $this->optionID[$cellIndex - 1];
                $keyExist = array_key_exists($optionID, $formattedRows);
                if (!$keyExist) {
                    $formattedRows[$optionID] = [];
                }
                if (in_array(trim(strtolower($cell)), ['yes', 'true'])) {
                    $formattedRows[$optionID] = [ ...$formattedRows[$optionID], $product_id];
                }
            }
        }
        foreach ($formattedRows as $optionID => $products) {
            if ($optionID == '') {continue;}
            ProductFilter::sync_product_filters($this->primary_id, $optionID, $products);
        }
    }
    #region function
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
    public function get_Filter($title, $description, $icon, $primary_id = -1): Filter
    {
        if (is_null($primary_id) || trim($primary_id) == '') {
            $primary_id = -1;
        } else {
            $primary_id = (int) $primary_id;
        }
        $primary_data = Filter::where('id', $primary_id);
        if ($primary_data->get()->count() == 0) {
            $primary_data = Filter::where('title', trim($title));
            if ($primary_data->get()->count() > 0) {
                return $primary_data->get()->first();
            }
            $primary_data = Filter::create(
                array(
                    'title' => $title,
                    'description' => $description,
                    'icon' => $icon,
                )
            );
        }
        $primary_data = $primary_data->get()->first();
        $primary_data->title = $title;
        $primary_data->description = $description;
        $primary_data->icon = $icon;
        $primary_data->save();
        return $primary_data;
    }
    public function get_Option($filter_id, $value, $option_id = -1): FilterChoice
    {
        $option_data = FilterChoice::where('id', $option_id);
        if ($option_data->get()->count() == 0) {
            $option_data = FilterChoice::where('filter_id', $filter_id)->where('value', trim($value));
            if ($option_data->get()->count() > 0) {
                return $option_data->get()->first();
            }
            return FilterChoice::create(
                array(
                    'filter_id' => $filter_id,
                    'value' => $value,
                )
            );
        }
        $option_data = $option_data->get()->first();
        $option_data->filter_id = $filter_id;
        $option_data->value = $value;
        $option_data->save();
        return $option_data;
    }
    #endregion
}
