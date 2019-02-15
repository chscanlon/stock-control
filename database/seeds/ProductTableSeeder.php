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

      $productName = "LOR Pack For Blonde Hair";
      $product = new Product;

      $product->supplier = "L'Oreal";
      $product->product_range = "";
      $product->display_name = $productName;
      $product->order_name = $productName;
      $product->supplier_sequence = "";
      $product->product_usage = "Retail";
      $product->current_max_stock = "0";
      $product->current_stock_available = "0";

      $product->save();

    }
}
