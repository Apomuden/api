<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientVitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_vitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->decimal('temperature', 20, 2)->nullable();
            $table->decimal('pulse', 20, 2)->nullable();
            $table->decimal('systolic_blood_pressure', 20, 2)->nullable();
            $table->decimal('diastolic_blood_pressure', 20, 2)->nullable();
            $table->decimal('respiration', 20, 2)->nullable();
            $table->decimal('weight', 20, 2)->nullable();
            $table->decimal('height', 20, 2)->nullable();
            $table->decimal('bmi', 20, 2)->nullable()->comment('Body Mass Index');
            $table->decimal('oxygen_saturation', 20, 2)->nullable()->comment('Oxygen Saturation (SPO2)');
            $table->decimal('fasting_blood_sugar', 20, 2)->nullable();
            $table->decimal('random_blood_sugar', 20, 2)->nullable();
            $table->longText('comment')->nullable();
            $table->enum('status',['IN-QUEUE','ACTIVE','INACTIVE'])->default('IN-QUEUE');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_vitals');
    }
}
