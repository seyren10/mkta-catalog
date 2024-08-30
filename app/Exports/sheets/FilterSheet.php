<?php

namespace App\Exports\sheets;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class FilterSheet implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    private $filter_data;
    public function __construct($data)
    {
        $this->filter_data = $data;
    }

    public function title(): string
    {
        return (string) ($this->filter_data->title);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'B1' => [
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
    
    public function array():array
    {
        return
        [
            [ 'ID', $this->filter_data->id ],
            [ 'title', $this->filter_data->title ],
            [ 'description', $this->filter_data->description ],
            [ 'icon', $this->filter_data->icon ],
            [''],
            ['', ...(collect($this->filter_data->choices)->pluck('id'))],
            ['Product', ...(collect($this->filter_data->choices)->pluck('value'))]
        ];
    }
}
