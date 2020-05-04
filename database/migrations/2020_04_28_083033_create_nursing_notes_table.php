<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nursing_notes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedInteger('clinic_type_id')->nullable();
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');

            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');

            $table->dateTime('consultation_date')->nullable();

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

            $table->uuid('consultant_id')->nullable()->comment('The nurse writing the note');
            $table->foreign('consultant_id')->references('id')->on('users')->onDelete('restrict');

            $table->enum('status', ['ACTIVE', 'INACTIVE', 'CANCELLED'])->default('ACTIVE');

            $table->dateTime('cancelled_date')->nullable();

            $table->uuid('canceller_id')->comment('The user who is cancelling the payment')->nullable();
            $table->foreign('canceller_id')->references('id')->on('users')->onDelete('restrict');

            $table->text('notes');

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
        Schema::dropIfExists('nursing_notes');
    }
}
