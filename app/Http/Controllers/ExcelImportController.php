<?php

namespace App\Http\Controllers;

use App\Exports\Export_Category;
use App\Exports\Export_ProductAccess;
use App\Exports\Export_ProductFilter;
use App\Imports\CategoryImport;
use App\Imports\ProductComponents;
use App\Imports\ProductFilters;
use App\Imports\ProductImport;
use App\Imports\ProductRestrictionAndExemptionv3;
use App\Imports\RelatedAndRecommendedProducts;
use App\Models\DataImport;
use App\Services\DataImportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{

    public static function template_downloads($template, $disk)
    {
        switch ($template) {
            case 'categories':
                Excel::store(new Export_Category, "resources/{$template}.xlsx", $disk);
                break;
            case 'product-filters':
                Excel::store(new Export_ProductFilter, "resources/{$template}.xlsx", $disk);
                break;
            case 'product-restriction-and-exemptions':
                Excel::store(new Export_ProductAccess, "resources/{$template}.xlsx", $disk);
                break;
            default:
                Excel::store(new Export_Category, "resources/categories.xlsx", $disk);
                Excel::store(new Export_ProductFilter, "resources/product-filters.xlsx", $disk);
                Excel::store(new Export_ProductFilter, "resources/product-restriction-and-exemptions.xlsx", $disk);
                break;
        }
    }
    public function importProducts(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new ProductImport(), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importProductsLink(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new RelatedAndRecommendedProducts($filePath, Carbon::now()), $filePath);
        return response()->json(['message' => 'Recommended and Related Product File is being processed!']);
    }
    public static function importProductComponents(Request $request)
    {
        Log::info(__FUNCTION__);
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::import(new ProductComponents($filePath, Carbon::now()), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importCategories(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::import(new CategoryImport($filePath, Carbon::now()), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importFilters(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new ProductFilters($filePath, Carbon::now()), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importProductRestrictionExemption(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new ProductRestrictionAndExemptionv3($filePath, Carbon::now()), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
}
