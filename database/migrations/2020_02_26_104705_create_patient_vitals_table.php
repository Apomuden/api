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
            $table->foreign('patient_id')->references('id')->references('patients')->onDelete('restrict');
            $table->decimal('temperature', 20, 9)->default(0.00);
            $table->decimal('pulse', 20, 9)->default(0.00);
            $table->decimal('systolic_blood_pressure', 20, 9)->default(0.00);
            $table->decimal('diastolic_blood_pressure', 20, 9)->default(0.00);
            $table->decimal('respiratory', 20, 9)->default(0.00);
            $table->decimal('weight', 20, 9)->default(0.00);
            $table->decimal('height', 20, 9)->default(0.00);
            $table->decimal('bmi', 20, 9)->default(0.00);
            $table->decimal('spo2', 20, 9)->default(0.00);
            $table->decimal('fasting_blood_sugar', 20, 9)->default(0.00);
            $table->decimal('random_blood_sugar', 20, 9)->default(0.00);
            $table->string('comment');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['patient','deleted_at']);
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
