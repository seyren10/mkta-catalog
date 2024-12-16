<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WishListExport implements FromView
{
    /**
     * Pass data into the export class.
     *
     * @param array $data
     */
    public function __construct($products = [])
    {
        $this->products = $products;
    }


    /**
     * Use a Blade view to format the Excel file.
     *
     * @return View
     */
    public function view(): View
    {
        return view('exports.wish_list', [
            'products' => $this->products
        ]);
    }
}
