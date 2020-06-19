<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousPregnanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previous_pregnancies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedInteger('patient_age');
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT'])->default('OUT-PATIENT');

            $table->date('date');
            $table->text('problem_during_pregnancy')->nullable();

            $table->unsignedBigInteger('birth_place_id');
            $table->foreign('birth_place_id')->references('id')->on('obs_birth_places')->onDelete('restrict');

            $table->unsignedBigInteger('gestational_week_id');
            $table->foreign('gestational_week_id')->references('id')->on('gestational_weeks')->onDelete('restrict');

            $table->unsignedBigInteger('delivery_mode_id');
            $table->foreign('delivery_mode_id')->references('id')->on('delivery_modes')->onDelete('restrict');

            $table->unsignedBigInteger('delivery_outcome_id');
            $table->foreign('delivery_outcome_id')->references('id')->on('delivery_outcomes')->onDelete('restrict');

            $table->text('labour_postpartum_complication')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE']);
            $table->double('birth_weight');
            $table->enum('child_health', ['GOOD', 'POOR', 'DEAD']);

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
            $table->unique(['patient_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previous_pregnancies');
    }
}
