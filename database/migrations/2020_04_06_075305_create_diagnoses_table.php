<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('diagnosis_type',['CONFIRM','PROVISIONAL','ADDITIONAL']);
            $table->enum('diagnosis_status',['NEW','OLD']);

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedInteger('funding_type_id');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');

            $table->unsignedInteger('sponsorship_type_id')->nullable();
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');

            $table->unsignedBigInteger('billing_sponsor_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');

            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');


            $table->unsignedInteger('age');
            $table->enum('gender', ['MALE', 'FEMALE', 'BIGENDER']);
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT'])->default('OUT-PATIENT');

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

            $table->string('disease_code')->nullable()->index();
            $table->string('icd10_code')->index();
            $table->string('icd10_grouping_code')->index();

            $table->unsignedBigInteger('icd10_grouping_id');
            $table->foreign('icd10_grouping_id')->references('id')->on('icd10_groupings')->onDelete('restrict');

            $table->unsignedBigInteger('icd10_category_id');
            $table->foreign('icd10_category_id')->references('id')->on('icd10_categories')->onDelete('restrict');

            $table->unsignedBigInteger('moh_ghs_grouping_id');
            $table->foreign('moh_ghs_grouping_id')->references('id')->on('moh_ghs_groupings')->onDelete('restrict');

            $table->string('moh_grouping_code')->index();

            $table->unsignedBigInteger('disease_id');
            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('restrict');

            $table->unsignedInteger('illness_type_id');
            $table->foreign('illness_type_id')->references('id')->on('illness_types')->onDelete('restrict');

            $table->boolean('require_surgery')->default(false);
            $table->boolean('require_investigation')->default(false);
            $table->string('adult_gdrg')->nullable();
            $table->unsignedDecimal('adult_tariff', 20, 2)->default(0.00);
            $table->string('child_gdrg')->nullable();
            $table->unsignedDecimal('child_tariff', 20, 2)->default(0.00);
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');

            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('diagnoses');
    }
}
