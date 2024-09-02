<?php

namespace App\Http\Controllers;

use App\Exports\Export_Category;
use App\Exports\Export_ProductFilter;
use App\Exports\Export_ProductAccess;


use App\Imports\CategoryImport;
use App\Imports\ProductFilters;
use App\Imports\ProductImport;
use App\Imports\ProductRestrictionAndExemption;
use App\Imports\RelatedAndRecommendedProducts;
use App\Models\ProductFilter;
use Illuminate\Http\Request;
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
        Excel::queueImport(new ProductImport, $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importProductsLink(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new RelatedAndRecommendedProducts($filePath), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importCategories(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new CategoryImport($filePath), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importFilters(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new ProductFilters($filePath), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
    public static function importProductRestrictionExemption(Request $request)
    {
        $path = Storage::disk('local')->put("public", $request->file('eFile'));
        $filePath = Storage::disk('local')->path($path);
        Excel::queueImport(new ProductRestrictionAndExemption($filePath), $filePath);
        return response()->json(['message' => 'File is being processed!']);
    }
}
