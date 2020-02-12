<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('main_clinic_id');
            $table->foreign('main_clinic_id')->references('id')->on('service_categories')->onDelete('restrict');
            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDDelete('restrict');

            $table->set('gender',['MALE','FEMALE','BIGENDER'])->default('MALE,FEMALE,BIGENDER');

            $table->set('patient_status',['IN-PATIENT','OUT-PATIENT','WALK-IN'])->default('IN-PATIENT,OUT-PATIENT,WALK-IN');

            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinics');
    }
}
