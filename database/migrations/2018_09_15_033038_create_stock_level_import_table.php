<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockLevelImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_level_import', function (Blueprint $table) {
            $table->string('ProductName');
            $table->string('SkuHandle');
            $table->string('ProductLocation');
            $table->string('StockAvailable');
            $table->string('ReorderAlertThreshold');
            $table->string('Textbox49');
            $table->string('UnitCostPrice');
            $table->string('UnitRetailPrice');
            $table->string('TotalCostValue');
            $table->string('TotalRetailValue');
            $table->string('TotalStockAvailable');
            $table->string('Textbox50');
            $table->string('TotalUnitCostPrice');
            $table->string('TotalUnitRetailPrice');
            $table->string('TotalTotalCostValue');
            $table->string('TotalTotalRetailValue');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_level_import');
    }
}
