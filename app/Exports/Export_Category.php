<?php
namespace App\Exports;

use App\Exports\Sheets\CategorySheet;
use App\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Export_Category implements WithMultipleSheets, ShouldQueue
{
    use Exportable;

    public function __construct()
    {
        // Constructor if needed
    }

    public function sheets(): array
    {
        $sheets = [];
        
        $categories = Category::withOutEagerLoads()
            ->with(['parent_category', 'export_products'])
            ->select('id', 'title', 'parent_id', 'description')
            ->get();
            
        foreach ($categories as $category) {
            $title = $category->parent_category ? $category->parent_category->title .' - ' : '';
            $title = $title.$category->title;
            $sheets[] = new CategorySheet($title, $category->toArray());
        }

        return $sheets;
    }
}
