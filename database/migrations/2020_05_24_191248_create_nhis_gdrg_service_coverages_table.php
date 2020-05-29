<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhisGdrgServiceCoveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhis_gdrg_service_coverages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gdrg_code');
            $table->string('mdc_code');
            $table->unsignedBigInteger('nhis_gdrg_service_tariff_id');
            $table->foreign('nhis_gdrg_service_tariff_id')->references('id')->on('nhis_gdrg_service_tariffs')->onDelete('restrict');
            $table->enum('out_patient',['YES','NO'])->default('NO');
            $table->enum('in_patient',['YES','NO'])->default('NO');
            $table->enum('surgery',['YES','NO'])->default('NO');
            $table->enum('non_surgery',['YES','NO'])->default('NO');
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
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
        Schema::dropIfExists('nhis_gdrg_service_coverages');
    }
}
