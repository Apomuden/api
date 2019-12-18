<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryAndRegionToHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->after('gps_location')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
            $table->unsignedBigInteger('region_id')->after('country_id')->nullable();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
            $table->dropForeign(['region_id']);
            $table->dropColumn('region_id');
        });
    }
}
