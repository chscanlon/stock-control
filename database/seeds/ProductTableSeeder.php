<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Stocktake;
use Carbon\Carbon;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = new Product;

        $product->supplier = "L'Oreal";
        $product->product_range = "Techni Art";
        $product->display_name = "LOR TA Fix Max 200ml";
        $product->supplier_sequence = "08.16.015";
        $product->product_usage = "Retail";
        $product->current_max_stock = "1";
        $product->current_stock_available = "0";

        $product->save();

    }
}
