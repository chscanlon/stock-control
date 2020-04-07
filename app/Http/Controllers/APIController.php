<?php

namespace App\Http\Controllers;

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
        return datatables(Product::select(
            'id',
            'supplier',
            'product_usage',
            'product_range',
            'display_name',
            'current_max_stock',
            'current_stock_available'
        )->where([
            ['discontinued', 0],
            ['timely_product_status', 'active'],
        ]))->toJson();
    }
}
