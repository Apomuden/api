<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedInteger('clinic_type_id')->nullable();
            $table->uuid('doctor_id')->nullable();
            $table->uuid('entered_by');
            $table->dateTime('appointment_date')->useCurrent();
            $table->enum('status', ['ACTIVE,INACTIVE'])->default('ACTIVE');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('entered_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');
            $table->unique(['patient_id','appointment_date','doctor_id','clinic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}