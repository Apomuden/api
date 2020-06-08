<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhisGdrgServiceTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhis_gdrg_service_tariffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gdrg_code');
            $table->string('gdrg_service_name');

            $table->unsignedBigInteger('nhis_provider_level_id');
            $table->foreign('nhis_provider_level_id')->references('id')->on('nhis_provider_levels')->onDelete('restrict');

            $table->unsignedBigInteger('major_diagnostic_category_id');
            $table->foreign('major_diagnostic_category_id')->references('id')->on('major_diagnostic_categories');

            $table->string('mdc_code');
            $table->unsignedDecimal('tariff', 20, 2)->default(0.00);
            $table->unsignedInteger('hospital_service_id');
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');
            $table->set('patient_status', ['OUT-PATIENT', 'IN-PATIENT']);
            $table->set('gender', ['MALE', 'FEMALE', 'BIGENDER']);
            $table->unsignedInteger('age_group_id');
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['gdrg_code','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhis_gdrg_service_tariffs');
    }
}
