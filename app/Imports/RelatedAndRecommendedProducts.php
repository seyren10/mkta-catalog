<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\RecommendedProduct;
use App\Models\RelatedProduct;
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
    private $key;
    public function __construct($filePath, $key)
    {
        $this->filePath = $filePath;
        $this->key = $key;
        Log::info($this->key);
    }
    public function sheets(): array
    {
        $sheetNames = $this->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new RelatedAndRecommendedProducts($this->filePath, $this->key);
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
                $curProduct = Product::find($this->product_id);

                if ($curProduct === null) {
                    $this->product_id = -1;
                    return;
                }

                $importData = DataImportService::getDataImport('import-products-links', $this->product_id, $this->key);
                
                if( $importData->pass_key != $this->key ){
                    // Pass key is Different
                    // things should update
                    Schema::disableForeignKeyConstraints();
                    RelatedProduct::where('product_id', $this->product_id)->delete();
                    RecommendedProduct::where('product_id', $this->product_id)->delete();
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
        
        Log::info($this->product_id);
        if( $this->product_id === -1 ){ return; }

        $related = [];
        $recommended = [];
        foreach ($rows as $key => $row) {
            array_push($related, $row[0]);
            array_push($recommended, $row[1]);
        }

        $related = collect(Product::whereIn('id', $related)->get())->pluck('id');
        $recommended = collect(Product::whereIn('id', $recommended)->get())->pluck('id');

        $curProduct = $this->product_id;
        $temp = array_map(
            function($productId) use ( $curProduct) {
            return [
                'related_product_id' => $productId,
                'product_id' => $curProduct,
            ];
        }, $related->toArray() );
        RelatedProduct::insert($temp);

        $temp = array_map(
            function($productId) use ( $curProduct) {
            return [
                'recommended_product_id' => $productId,
                'product_id' => $curProduct,
            ];
        }, $recommended->toArray() );
        RecommendedProduct::insert($temp);

    }

}
