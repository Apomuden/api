<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTariffTypeToNhisAccreditationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhis_accreditation_settings', function (Blueprint $table) {
            $table->enum('tariff_type',['CAPITATION','GDRG'])->after('nhis_authorization_code')->default('GDRG')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nhis_accreditation_settings', function (Blueprint $table) {
            $table->dropIndex(['tariff_type']);
            $table->dropColumn('tariff_type');
        });
    }
}
