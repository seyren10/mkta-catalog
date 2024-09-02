<?php

namespace App\Console\Commands;

use App\Http\Controllers\ExcelImportController;
use Illuminate\Console\Command;

class UploadExportableTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-exportable-templates {option=all} {disk=s3}';
    // php artisan app:upload-exportable-templates product-filters

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Exportable Excel templates to AWS S3';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ExcelImportController::template_downloads($this->argument('option'), $this->argument('disk'));
    }
}
