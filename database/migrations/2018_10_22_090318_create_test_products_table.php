<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('test_products', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->string('supplier')->default('')->comment("eg L'Oreal");
          $table->string('barcode')->default('');
          $table->string('product_range')->default('');
          $table->string('display_name')->default('')->unique();
          $table->string('order_name')->default('');
          $table->string('supplier_sequence')->default('');
          $table->boolean('discontinued')->default(false);
          $table->string('product_usage')->default('')->comment("eg Professional, Retail");
          $table->integer('current_max_stock')->nullable($value = true);
          $table->integer('current_stock_available')->nullable($value = true);
          $table->decimal('current_cost_price', 8, 2)->nullable($value = true);
          $table->decimal('current_retail_price', 8, 2)->nullable($value = true);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_products');
    }
}
