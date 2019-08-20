<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Datatables;

class APIController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts()
    {
        return datatables(
            Product::select(
                          'product_usage',
                          'product_range',
                          'display_name',
                          'supplier_sequence',
                          'current_max_stock',
                          'current_stock_available'
                          )
                          ->where([
                            ['timely_product_status', 'active'],
                            ['supplier', "L'Oreal"],
                            ['discontinued', 0],
                          ])
                          )->toJson();
    }
}
