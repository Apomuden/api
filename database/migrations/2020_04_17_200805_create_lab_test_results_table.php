<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabTestResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_test_results', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedBigInteger('investigation_id');
            $table->foreign('investigation_id')->references('id')->on('investigations')->onDelete('restrict');

            $table->unsignedBigInteger('lab_parameter_id');
            $table->foreign('lab_parameter_id')->references('id')->on('lab_parameters')->onDelete('restrict');

            $table->string('lab_parameter_name');
            $table->string('lab_parameter_description');
            $table->enum('value_type',['Text', 'Number']);
            $table->string('test_value');

            $table->unsignedInteger('parameter_order');

            $table->unsignedBigInteger('lab_parameter_range_id')->nullable();
            $table->foreign('lab_parameter_range_id')->references('id')->on('lab_parameter_ranges')->onDelete('restrict');

            $table->string('flag')->nullable();
            $table->enum('min_comparator',['>', '>=', '<', '<=', '='])->nullable();
            $table->unsignedDecimal('min_value',10,2)->nullable();

            $table->enum('max_comparator', ['>', '>=', '<', '<=', '='])->nullable();
            $table->unsignedDecimal('max_value', 10, 2)->nullable();

            $table->unsignedInteger('min_age')->nullable();
            $table->enum('min_age_unit',['DAY', 'WEEK', 'MONTH', 'YEAR'])->nullable();

            $table->unsignedInteger('max_age')->nullable();
            $table->enum('max_age_unit', ['DAY', 'WEEK', 'MONTH', 'YEAR'])->nullable();


            $table->unsignedInteger('hospital_service_id');
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');

            $table->unsignedBigInteger('service_category_id');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');

            $table->unsignedBigInteger('service_subcategory_id')->nullable();
            $table->foreign('service_subcategory_id')->references('id')->on('service_subcategories')->onDelete('restrict');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');

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

            $table->unsignedDecimal('prepaid_total', 20, 2)->default(0.00);
            $table->unsignedDecimal('postpaid_total', 20, 2)->default(0.00);

            $table->uuid('technician_id');
            $table->foreign('technician_id')->references('id')->on('users')->onDelete('restrict');

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->dateTime('cancelled_date')->nullable();

            $table->uuid('canceller_id')->comment('The user who is cancelling the payment')->nullable();
            $table->foreign('canceller_id')->references('id')->on('users')->onDelete('restrict');

            $table->dateTime('test_date');

            $table->timestamps();
            $table->enum('status', ['ACTIVE','INACTIVE','CANCELLED'])->default('ACTIVE');
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
        Schema::dropIfExists('lab_test_results');
    }
}
