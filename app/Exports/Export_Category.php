<?php
namespace App\Exports;

use App\Exports\sheets\CategorySheet;
use App\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
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
        $categories = Category::with(['parent_category', 'export_products'])
            // ->take(1)
            ->select('id', 'title', 'parent_id', 'description')
            ->get(); // Fetch all categories
        $categories = ($categories->toArray());
        foreach ($categories as $category) {
            $sheets[] = new CategorySheet($category);
        }
        return $sheets;
    }
}
