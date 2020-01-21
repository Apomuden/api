<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicConsultServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_consult_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('display_name')->nullable();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('service_category_id');
            $table->unsignedDecimal('price',20, 2);
            $table->unsignedInteger('billing_cycle_id');
            $table->unsignedInteger('duration');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');
            $table->foreign('billing_cycle_id')->references('id')->on('billing_cycles')->onDelete('restrict');
            $table->unique(['display_name','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_consult_services');
    }
}
