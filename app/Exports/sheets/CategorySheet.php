<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

// class CategorySheet implements FromArray, WithTitle, WithStrictNullComparison
class CategorySheet implements FromCollection, WithTitle, WithStrictNullComparison, WithStyles, ShouldAutoSize
{
    protected $category;
    protected $title;

    public function __construct($title, $category)
    {
        $this->title = $title;
        $this->category = $category;
    }
    public function title(): string
    {
        return (string) $this->title;
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

    public function collection()
    {
        $products = [];
        foreach (($this->category['export_products']) as $key => $value) {
            array_push($products, [$value['product_id']]);
        }
        // Log::info($this->title);
        // Log::info($products);
        return collect([

            [
                'ID',
                'Parent',
                'Title',
                'Description',
            ],
            [
                $this->category['id'],
                $this->title,
                $this->category['title'],
                $this->category['description'],
                'Product will be also added to the parent category',
            ],
            ['Products'],
            ...$products,
        ]);
    }
}
