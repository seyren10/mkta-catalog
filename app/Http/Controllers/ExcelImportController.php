<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{

    public function importProducts(Request $request)
    {
        /* DO NOT USE XSL FORMAT , queue will not work */
        $xlsxFile = $request->file;
        Excel::queueImport(new ProductImport, $xlsxFile);
    }
}
