<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocktakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocktakes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('product_id');
            $table->integer('stocktake_event_id');
            $table->integer('max_stock')->nullable($value = true);
            $table->integer('available_stock')->nullable($value = true);
            $table->integer('items_to_order')->nullable($value = true);
            $table->decimal('cost_price', 8, 2)->nullable($value = true);
            $table->decimal('retail_price', 8, 2)->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocktakes');
    }
}
