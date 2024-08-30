<?php

namespace App\Exports\sheets;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class PATSheet implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
        Log::info($data);
    }

    public function title(): string
    {
        return (string) ($this->data->title);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B2:Z2');
        $sheet->mergeCells('B3:Z3');
        return [
            'B1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFFFDDDD'], // Light red background
                ],
            ],
            5 => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFFFDDDD'], // Light red background
                ],
            ],
        ];
    }

    public function array(): array
    {
        return
            [
            ['ID', $this->data->id],
            ['title', $this->data->title],
            ['description', $this->data->description],
            [''],
            ['', ...(collect($this->data->source_table)->pluck('id'))],
            ['Product', ...(collect($this->data->source_table)->pluck($this->data->display_column))],
        ];
    }
}
