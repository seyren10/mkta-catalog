<?php
namespace App\Exports;

use App\Exports\sheets\CategorySheet;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class Export_Category implements WithMultipleSheets
{
    use Exportable;

    public function __construct()
    {
        // Constructor if needed
    }

    public function sheets(): array
    {
        $sheets = [];
        $categories = Category::with(['parent_category', 'products'])->get(); // Fetch all categories
        foreach ($categories as $category) {
            $sheets[] = new CategorySheet($category);
        }
        return $sheets;
    }
}
