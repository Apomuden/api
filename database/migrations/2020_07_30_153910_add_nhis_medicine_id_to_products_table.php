<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNhisMedicineIdToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('nhis_medicine_id')->nullable()->after('nhis_cover');
            $table->foreign('nhis_medicine_id')->references('id')->on('nhis_medicines')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['nhis_medicine_id']);
            $table->dropColumn('nhis_medicine_id');
        });
    }
}
