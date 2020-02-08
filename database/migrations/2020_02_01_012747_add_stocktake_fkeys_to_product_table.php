<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStocktakeFkeysToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('products', 'created_in_stocktake_id')) {
          Schema::table('products', function (Blueprint $table) {
            $table->integer('created_in_stocktake_id')->default(0);
            $table->integer('deleted_in_stocktake_id')->default(0);
          });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('products', function (Blueprint $table) {
          if (Schema::hasColumn('products', 'created_in_stocktake_id')) {
            $table->dropColumn('created_in_stocktake_id');
            $table->dropColumn('deleted_in_stocktake_id');
          }
      });
    }
}
