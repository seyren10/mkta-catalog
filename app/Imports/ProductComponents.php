<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductComponent;
use App\Services\DataImportService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;

class ProductComponents implements ToCollection, WithMultipleSheets, WithEvents
{

    use Importable, RegistersEventListeners;
    #region for Data
    private $filePath;
    private $product_id;
    private $key;
    public function __construct($filePath, $key)
    {
        Log::info(__FILE__ . " -> " . __FUNCTION__);
        $this->filePath = $filePath;
        $this->key = $key;
    }
    public function sheets(): array
    {
        $sheetNames = $this->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new ProductComponents($this->filePath, $this->key);
        }
        Log::info(__FILE__ . " -> " . __FUNCTION__);

        return $sheets;
    }
    private function getSheetNames(): array
    {
        Log::info(__FILE__ . " -> " . __FUNCTION__);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        return $spreadsheet->getSheetNames();
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->product_id = $event->sheet->getTitle();
                $curProduct = Product::find($this->product_id);
                Log::info(__FILE__ . " -> " . __FUNCTION__ . " -> " . $this->product_id);

                if ($curProduct === null) {
                    $this->product_id = -1;
                    return;
                }
                $importData = DataImportService::getDataImport('import-products-components', $this->product_id, $this->key);
                if ($importData->pass_key != $this->key) {
                    // Pass key is Different
                    // things should update
                    Schema::disableForeignKeyConstraints();
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
        // Early return if product_id is not valid
        if ($this->product_id === -1) {return;}
        ProductComponent::where('product_id', $this->product_id)->delete();
        $formattedRows = [];
        $currentIndex = -1;
        foreach ($rows as $row) {
            if ($row[0] === 'Attribute Title') {
                $currentIndex++;
                $formattedRows[$currentIndex] = [
                    "title" => $row[1],
                    "type" => 'list',
                    "is_visible" => 1,
                    "index" => 1,
                    "value" => [],
                    "product_id" => $this->product_id,
                ];
                continue;
            }

            // Skip empty titles or values
            if (empty($row[0]) || empty($row[1])) {
                continue;
            }

            $formattedRows[$currentIndex]['value'][] = [
                "icon" => null,
                "title" => $row[0],
                "value" => $row[1],
            ];
        }

        $formattedRows = collect($formattedRows)
            ->map(function ($row) {
                $row['value'] = json_encode($row['value']);
                return $row;
            });
        ProductComponent::insert($formattedRows->toArray());

    }

}
