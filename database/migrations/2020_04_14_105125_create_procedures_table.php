<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->uuid('consultant_id')->nullable()->comment('The doctor to whom the consultation service is assigned-user_id');
            $table->foreign('consultant_id')->references('id')->on('users')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedInteger('clinic_type_id');
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');

            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');

            $table->dateTime('consultation_date');

            $table->unsignedInteger('age');

            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');

            $table->unsignedInteger('age_class_id')->nullable();
            $table->foreign('age_class_id')->references('id')->on('age_classifications')->onDelete('restrict');
            $table->unsignedInteger('age_category_id')->nullable();
            $table->foreign('age_category_id')->references('id')->on('age_categories')->onDelete('restrict');

            $table->enum('gender', ['MALE', 'FEMALE', 'BIGENDER']);

            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT', 'WALK-IN'])->default('OUT-PATIENT');

            $table->unsignedInteger('hospital_service_id');
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');

            $table->unsignedBigInteger('service_category_id');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');

            $table->unsignedBigInteger('service_subcategory_id')->nullable();
            $table->foreign('service_subcategory_id')->references('id')->on('service_subcategories')->onDelete('restrict');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');

            $table->enum('order_type', ['INTERNAL', 'EXTERNAL']);

            $table->unsignedInteger('funding_type_id');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');

            $table->unsignedInteger('sponsorship_type_id')->nullable();
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');

            $table->unsignedBigInteger('billing_sponsor_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');

            $table->unsignedBigInteger('sponsorship_policy_id')->nullable();
            $table->foreign('sponsorship_policy_id')->references('id')->on('sponsorship_policies')->onDelete('restrict');

            $table->unsignedDecimal('prepaid_total', 20, 2)->default(0.00);
            $table->unsignedDecimal('postpaid_total', 20, 2)->default(0.00);

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->dateTime('cancelled_date')->nullable();

            $table->uuid('canceller_id')->comment('The user who is cancelling the payment')->nullable();
            $table->foreign('canceller_id')->references('id')->on('users')->onDelete('restrict');

            $table->enum('status', ['IN-QUEUE', 'ACTIVE', 'COMPLETED', 'APPROVED', 'CANCELLED'])->default('IN-QUEUE');
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
        Schema::dropIfExists('procedures');
    }
}
