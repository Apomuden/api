<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToStockAdjustmentProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_adjustment_products', function (Blueprint $table) {
            $table->enum('status',['PENDING','APPROVED','CANCELLED','SUSPENDED'])->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_adjustment_products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
