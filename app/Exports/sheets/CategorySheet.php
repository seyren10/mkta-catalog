<?php
namespace App\Exports\Sheets;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategorySheet implements FromArray, WithTitle, WithStyles, WithHeadings
{
    protected $category;

    public function headings(): array
    {
        return [
            'ID', 'Parent', 'Title', 'Description'
        ];
    }

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function array(): array
    {
        $products = [];
        foreach (collect($this->category->products) as $key => $value) {
            array_push($products, [$value->product_id, $value->title]);
        }
        $catData =  [
            [$this->category->id, ($this->category->parent_category ? $this->category->parent_category->title: ''), $this->category->title, $this->category->description, 'Product will be also added to the parent category'],
            ['Products'],
            ...$products
        ];
        return $catData;
    }

    public function title(): string
    {
        return (string) ($this->category->parent_category ? $this->category->parent_category->title . ' -> ' : '') . $this->category->title; // Sheet title is the category ID
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'A2' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFFFDDDD'], // Light red background
                ]
            ],
            6 => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFFFDDDD'], // Light red background
                ]
            ]
        ];
    }
    protected function autoFit(Worksheet $sheet)
    {
        // Auto-fit columns
        foreach ($sheet->getColumnDimensions() as $columnDimension) {
            $columnDimension->setAutoSize(true);
        }

        // Auto-fit rows
        foreach ($sheet->getRowDimensions() as $rowDimension) {
            $rowDimension->setRowHeight(-1); // Automatically adjust row height
        }
    }
}
