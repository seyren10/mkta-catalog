<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
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
    private $parent;
    private $key;
    public function __construct($filePath, $key)
    {
        $this->filePath = $filePath;
        $this->key = $key;
    }
    public function sheets(): array
    {
        $sheetNames = $this->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new CategoryImport($this->filePath, $this->key);
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

                $catData = self::get_Category($event->sheet->getCell('A2')->getValue(), $event->sheet->getCell('C2')->getValue(), $event->sheet->getCell('D2')->getValue());
                $this->id = $catData->id;
                $this->parent = $catData->parent_category->id ?? null;
                
                $importData = DataImportService::getDataImport('import-categories', $this->id, $this->key);
                if( $importData->pass_key != $this->key ){
                    // Pass key is Different
                    // things should update
                    Schema::disableForeignKeyConstraints();
                    ProductCategory::where('category_id', $this->id)->delete();
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
        $products = [];
        foreach ($rows as $key => $row) {
            $products[] = $row[0];
        }
        $curCat = $this->id;
        $products = collect(Product::whereIn('id', $products)->get())->pluck('id');
        $temp = array_map(
            function($productId) use ($curCat) {
            return [
                'category_id' => $curCat,
                'product_id' => $productId,
            ];
        }, $products->toArray() );
        ProductCategory::insert($temp);

        if($this->parent != null){
            $parent = $this->parent;
            $temp = array_map(
                function($productId) use ($parent) {
                    $data= [
                        'category_id' => $parent,
                        'product_id' => $productId,
                    ];
                return $data;
            }, $products->toArray() );
            ProductCategory::insert($temp);
        }

    }
    public function get_Category($id, $title, $description, $update = true) : Category
    {
        $curCategory = Category::find($id);
        if ($curCategory === null) {
            return Category::create(
                array(
                    'title' =>$title,
                    'description' =>$description,
                )
            );
        }
        if($update){
            $curCategory->title = $title;
            $curCategory->description = $description;
            $curCategory->save();
        }
        
        return $curCategory;
    }
}
