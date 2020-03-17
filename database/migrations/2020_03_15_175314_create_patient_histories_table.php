<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedInteger('funding_type_id');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');

            $table->unsignedInteger('sponsorship_type_id')->nullable();
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');

            $table->unsignedBigInteger('billing_sponsor_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');

            $table->unsignedInteger('age');
            $table->enum('gender',['MALE','FEMALE','BIGENDER']);
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT'])->default('OUT-PATIENT');

            $table->text('presenting_complaints')->nullable();
            $table->text('presenting_complaints_history')->nullable();
            $table->text('direct_questions')->nullable();
            $table->text('past_medical_history')->nullable();
            $table->text('surgical_history')->nullable();
            $table->text('medicine_history')->nullable();
            $table->text('allergies_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('social_history')->nullable();

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->uuid('consultant_id')->nullable()->comment('The doctor to whom the consultation service is assigned-user_id');
            $table->foreign('consultant_id')->references('id')->on('users')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedInteger('clinic_type_id');
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');

            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->dateTime('consultation_date');
            $table->dateTime('attendance_date');

            $table->unsignedInteger('chief_complaint_relation_id')->nullable();
            $table->foreign('chief_complaint_relation_id')->references('id')->on('relationships')->onDelete('restrict');


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
        Schema::dropIfExists('patient_histories');
    }
}
