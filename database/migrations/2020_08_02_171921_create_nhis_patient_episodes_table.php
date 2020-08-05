<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhisPatientEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhis_patient_episodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->string('episode_no');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->enum('gender',['MALE','FEMALE']);
            $table->unsignedInteger('age');
            $table->enum('patient_status',['OUT-PATIENT','IN-PATIENT','WALK-IN']);
            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('attendance_date');
            $table->dateTime('start_episode');
            $table->dateTime('end_episode')->nullable();
            $table->unsignedInteger('episode_duration')->default(0);
            $table->unsignedBigInteger('billing_sponsor_id');
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');
            $table->string('schema_code')->nullable();
            $table->string('member_id')->nullable();
            $table->string('card_serial_no')->nullable();
            $table->string('ccc')->nullable();
            $table->unsignedBigInteger('episode_service_tariff_id')->nullable();
            $table->foreign('episode_service_tariff_id')->references('id')->on('nhis_gdrg_service_tariffs')->onDelete('restrict');
            $table->string('episode_gdrg_code')->nullable();
            $table->unsignedDecimal('episode_gdrg_fee',20,2)->default(0.00);
            $table->string('episode_specialty')->nullable();
            $table->unsignedInteger('hospital_service_id')->nullable();
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');
            $table->unsignedBigInteger('service_category_id')->nullable();
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');
            $table->unsignedDecimal('service_fee',20,2)->default(0.00);
            $table->unsignedDecimal('medicine_fee',20,2)->default(0.00);
            $table->unsignedDecimal('diagnostic_fee',20,2)->default(0.00);

            $table->uuid('episode_clinician_id')->nullable();
            $table->foreign('episode_clinician_id')->references('id')->on('users')->onDelete('restrict');

            $table->unsignedBigInteger('claim_service_tariff_id')->nullable();
            $table->foreign('claim_service_tariff_id')->references('id')->on('nhis_gdrg_service_tariffs')->onDelete('restrict');

            $table->string('claim_gdrg_code')->nullable();


            $table->string('claim_diagnosis_icd10_code')->nullable();

            $table->unsignedBigInteger('claim_diagnosis_id')->nullable();
            $table->foreign('claim_diagnosis_id')->references('id')->on('diagnoses')->onDelete('restrict');

            $table->unsignedInteger('episode_illness_type_id')->nullable();
            $table->foreign('episode_illness_type_id')->references('id')->on('illness_types')->onDelete('restrict');

            $table->enum('episode_bundle',['NO','YES'])->default('NO');

            $table->unsignedInteger('episode_outcome_id')->nullable();
            $table->foreign('episode_outcome_id')->references('id')->on('discharge_reasons')->onDelete('restrict');

            $table->enum('archived',['NO','YES'])->default('NO');
            $table->dateTime('archived_at')->nullable();

            $table->uuid('archived_by')->nullable();
            $table->foreign('archived_by')->references('id')->on('users')->onDelete('restrict');

            $table->enum('processed',['NO','YES'])->default('NO');

            $table->dateTime('processed_at')->nullable();

            $table->uuid('processed_by')->nullable();
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('restrict');

            $table->enum('approved', ['NO', 'YES'])->default('NO');

            $table->dateTime('approved_at')->nullable();


            $table->enum('rejected', ['NO', 'YES'])->default('NO');

            $table->dateTime('rejected_at')->nullable();


            $table->uuid('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('restrict');


            $table->enum('printed',['NO','YES'])->default('NO');
            $table->dateTime('printed_at')->nullable();

            $table->uuid('printed_by')->nullable();
            $table->foreign('printed_by')->references('id')->on('users')->onDelete('restrict');


            $table->enum('diagnosis_edited',['NO','YES'])->default('NO');

            $table->enum('medicine_edited',['NO','YES'])->default('NO');

            $table->enum('service_edited',['NO','YES'])->default('NO');

            $table->enum('investigation_edited',['NO','YES'])->default('NO');

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
        Schema::dropIfExists('nhis_patient_episodes');
    }
}
