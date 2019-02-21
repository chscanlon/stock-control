<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReorderAlertThreasholdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('products', 'reorder_alert_threshold')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('reorder_alert_threshold')->nullable($value = true);
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
            if (Schema::hasColumn('products', 'reorder_alert_threshold')) {
                $table->dropColumn('reorder_alert_threshold');
            }
        });
    }
}
