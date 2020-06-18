<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProviderLevelAndTariff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nhis_gdrg_service_tariffs', function (Blueprint $table) {
            if (Schema::hasColumn('nhis_gdrg_service_tariffs', 'nhis_provider_level_id')) {
                $table->dropForeign(['nhis_provider_level_id']);
                $table->dropColumn('nhis_provider_level_id');
                $table->dropColumn('tariff');
            }
        });

        Schema::create('nhis_provider_level_tariffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nhis_gdrg_service_tariff_id');
            $table->foreign('nhis_gdrg_service_tariff_id')->references('id')->on('nhis_gdrg_service_tariffs')->onDelete('cascade');
            $table->unsignedBigInteger('nhis_provider_level_id');
            $table->foreign('nhis_provider_level_id')->references('id')->on('nhis_provider_levels')->onDelete('restrict');
            $table->unsignedDecimal('tariff',20,2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhis_provider_level_tariffs');
    }
}
