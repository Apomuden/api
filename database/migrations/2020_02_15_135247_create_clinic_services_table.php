<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->unsignedInteger('clinic_type_id');
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');
            $table->unsignedInteger('hospital_service_id');
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');
            $table->unsignedBigInteger('service_category_id');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');
            $table->unsignedBigInteger('service_subcategory_id')->nullable();
            $table->foreign('service_subcategory_id')->references('id')->on('service_subcategories')->onDelete('restrict');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');
            $table->unsignedInteger('billing_cycle_id');
            $table->foreign('billing_cycle_id')->references('id')->on('billing_cycles')->onDelete('restrict');
            $table->unsignedInteger('billing_duration');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['clinic_id', 'service_id','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_services');
    }
}
