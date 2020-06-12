<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTariffTypeToNhisGdrgServiceTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhis_gdrg_service_tariffs', function (Blueprint $table) {
            $table->set('tariff_type',['CHILD','ADULT'])->index()->after('age_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nhis_gdrg_service_tariffs', function (Blueprint $table) {
            $table->dropIndex(['tariff_type']);
            $table->dropColumn('tariff_type');
        });
    }
}
