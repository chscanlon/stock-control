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

      $productName = "LOR SE Blondifier Shampoo 300ml";
      $product = new Product;

      $product->supplier = "L'Oreal";
      $product->product_range = "Serie Expert Blondifier";
      $product->display_name = $productName;
      $product->order_name = $productName;
      $product->supplier_sequence = "08.041.01";
      $product->product_usage = "Retail";
      $product->current_max_stock = "0";
      $product->current_stock_available = "0";

      $product->save();

    }
}
