<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimelyProductIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         if (!Schema::hasColumn('products', 'timely_product_id')) {
             Schema::table('products', function (Blueprint $table) {
                 $table->integer('timely_product_id')->default(0);
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
             if (Schema::hasColumn('products', 'timely_product_id')) {
                 $table->dropColumn('timely_product_id');
             }
         });
     }
}
