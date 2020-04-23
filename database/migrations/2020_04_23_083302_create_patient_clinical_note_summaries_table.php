<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientClinicalNoteSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_clinical_note_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedInteger('age');

            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');

            $table->unsignedInteger('age_class_id')->nullable();
            $table->foreign('age_class_id')->references('id')->on('age_classifications')->onDelete('restrict');
            $table->unsignedInteger('age_category_id')->nullable();
            $table->foreign('age_category_id')->references('id')->on('age_categories')->onDelete('restrict');

            $table->enum('gender', ['MALE', 'FEMALE', 'BIGENDER']);

            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT', 'WALK-IN'])->default('OUT-PATIENT');

            $table->unsignedInteger('funding_type_id');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');

            $table->unsignedInteger('sponsorship_type_id')->nullable();
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');

            $table->unsignedBigInteger('billing_sponsor_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');

            $table->unsignedBigInteger('sponsorship_policy_id')->nullable();
            $table->foreign('sponsorship_policy_id')->references('id')->on('sponsorship_policies')->onDelete('restrict');

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

       
            $table->text('treatment_plan')->nullable();
            $table->text('physician_note')->nullable();
            $table->text('nursing_note')->nullable();
            $table->text('delivery_note')->nullable();
            $table->text('procedure_note')->nullable();
            $table->text('admission_note')->nullable();
            $table->text('progress_note')->nullable();
            $table->text('urgent_care_note')->nullable();

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');

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
        Schema::dropIfExists('patient_clinical_note_summaries');
    }
}
