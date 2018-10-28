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
            $table->dateTime('stocktake_date');
            $table->string('stock_level_import_filename')->unique();
            $table->integer('product_count');
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
