<?php

namespace App\Exports\Sheets;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategorySheet implements FromCollection, WithTitle, WithStyles, WithHeadings, ShouldAutoSize
{

    protected $category;
    protected $title;
    
    public function headings(): array
    {
        return [
            'ID',
            'Parent',
            'Title',
            'Description',
        ];
    }

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function collection()
    {
        $products = [];
        foreach (($this->category['export_products']) as $key => $value) {
            array_push($products, [$value['product_id']]);
        }
        $catData = [
            [
                $this->category['id'], 
                $this->title, 
                $this->category['title'], 
                $this->category['description'], 
                'Product will be also added to the parent category'
            ],
            ['Products'],
            ...$products,
        ];
        // Log::info($catData);
        return collect($catData);
    }
    public function title(): string
    {
        $this->title = (string) ($this->category['parent_category'] ? $this->category['parent_category']['title'] . ' -> ' : '') . $this->category['title']; // Sheet title is the category ID
        return $this->title;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A2' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFFFDDDD'], // Light red background
                ],
            ],
        ];
    }
}
