<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('supplier')->default('');
            $table->string('display_name')->default('');
            $table->string('supplier_product_name')->default('');
            $table->string('supplier_sequence')->default('');
            $table->integer('max_stock')->nullable($value = true);
            $table->integer('available_stock')->nullable($value = true);
            $table->integer('order_amount')->nullable($value = true);
            $table->decimal('cost_price', 8, 2)->nullable($value = true);
            $table->decimal('total_price', 8, 2)->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
