<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class templateImport implements ToCollection, ShouldQueue, WithStartRow, WithChunkReading, WithEvents, WithMultipleSheets
{

    use Importable, RegistersEventListeners;
    public function chunkSize(): int
    {
        return 1000;
    }
    public function startRow(): int
    {
        return 4;
    }

    #region for Data
    private $filePath;
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }
    private function getSheet($SheetName): Worksheet
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        return $spreadsheet->getSheetByName($SheetName);
    }
    private $curSheet;
    public function sheets(): array
    {
        Log::info("sheets");
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($this->filePath);
        $sheetNames = $spreadsheet->getSheetNames();
        $sheets = [];
        foreach ($sheetNames as $sheetName) {
            $sheets[$sheetName] = new templateImport($this->filePath);
        }
        return $sheets;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->curSheet = $event->sheet;
                $this->curSheet = $this->getSheet($event->sheet->getTitle());
            },
        ];
    }
    #endregion
    public function collection(Collection $rows)
    {
        Log::info("C2: " . $this->curSheet->getCell('C2')->getValue());
        Log::info("E2: " . $this->curSheet->getCell('E2')->getValue());
        Log::info("Rows: " . count($rows));
    }

}
