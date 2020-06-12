<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChildTariffIdAndAdultTariffIdToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->unsignedBigInteger('nhis_child_tariff_id')->after('postpaid_amount')->nullable();
            $table->foreign('nhis_child_tariff_id')->references('id')->on('nhis_gdrg_service_tariffs')->onDelete('restrict');
            $table->unsignedBigInteger('nhis_adult_tariff_id')->after('nhis_child_tariff_id')->nullable();
            $table->foreign('nhis_adult_tariff_id')->references('id')->on('nhis_gdrg_service_tariffs')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['nhis_child_tariff_id']);
            $table->dropForeign([ 'nhis_adult_tariff_id']);
            $table->dropColumn(['nhis_child_tariff_id', 'nhis_adult_tariff_id']);
        });
    }
}
