<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockLevelXlsxImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('stock_level_xlsx_import')) {
            Schema::create('stock_level_xlsx_import', function (Blueprint $table) {
                $table->integer('timely_product_id');
                $table->string('product_name');
                $table->string('sku_handle');
                $table->string('product_location');
                $table->string('stock_available');
                $table->string('reorder_alert_threshold');
                $table->string('tax_amount');
                $table->string('unit_cost_price');
                $table->string('unit_retail_price');
                $table->string('total_cost_value');
                $table->string('total_retail_value');
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
        Schema::dropIfExists('stock_level_xlsx_import');
    }
}
