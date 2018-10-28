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
      $this->newProduct();
    }

    public function newProduct()
    {
      $product = new Product;

      $product->supplier = "L'Oreal";
      $product->product_range = "Colorful Hair";
      $product->display_name = "Colorful Hair Yellow Sun 90ml";
      $product->supplier_sequence = "";
      $product->product_usage = "Professional";
      $product->current_max_stock = "1";
      $product->current_stock_available = "0";

      $product->save();

    }
}
