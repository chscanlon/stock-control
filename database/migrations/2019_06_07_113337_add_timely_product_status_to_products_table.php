<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimelyProductStatusToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         if (!Schema::hasColumn('products', 'timely_product_status')) {
             Schema::table('products', function (Blueprint $table) {
                 $table->string('timely_product_status')->default('active');
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
             if (Schema::hasColumn('products', 'timely_product_status')) {
                 $table->dropColumn('timely_product_status');
             }
         });
     }
}
