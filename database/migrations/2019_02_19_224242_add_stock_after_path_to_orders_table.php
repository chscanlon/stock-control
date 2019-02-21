<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStockAfterPathToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('orders', 'stock_after_file_path')) {
          Schema::table('orders', function (Blueprint $table) {
              $table->string('stock_after_file_path')->default('')->comment("local path to stock level report created after order check in");
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
      Schema::table('orders', function (Blueprint $table) {
          if (Schema::hasColumn('orders', 'stock_after_file_path')) {
              $table->dropColumn('stock_after_file_path');
          }
      });
    }
}
