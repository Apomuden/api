<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->unsignedInteger('clinic_type_id');
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');
            $table->unsignedInteger('age');
            $table->enum('gender',['MALE','FEMALE','BIGENDER']);
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT', 'WALK-IN'])->default('OUT-PATIENT');
            $table->unsignedInteger('hospital_service_id');
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');
            $table->unsignedBigInteger('service_category_id');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');
            $table->unsignedBigInteger('service_subcategory_id')->nullable();
            $table->foreign('service_subcategory_id')->references('id')->on('service_subcategories')->onDelete('restrict');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');
            $table->unsignedDecimal('service_fee', 20, 2)->default(0.00);
            $table->unsignedInteger('service_quantity')->default(1);
            $table->unsignedDecimal('service_total_amt',20,2)->default(0.00);
            $table->dateTime('service_date')->nullable();
            $table->uuid('user_id')->comment('The user who made the request');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->enum('order_type', ['INTERNAL', 'EXTERNAL'])->default('INTERNAL');
            $table->uuid('orderer_id')->comment('The user who ordered for the request');
            $table->foreign('orderer_id')->references('id')->on('users')->onDelete('restrict');
            //$table->boolean('part_payment')->default(false);
            $table->boolean('prepaid')->default(true);
            $table->unsignedDecimal('paid_service_price',20,2)->default(0.00);
            $table->unsignedInteger('paid_service_quantity')->default(0);
            $table->unsignedDecimal('paid_service_total_amt', 20, 2)->default(0.00);
            //$table->boolean('full_payment');

            $table->unsignedInteger('funding_type_id');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');

            $table->unsignedInteger('billing_system_id');
            $table->foreign('billing_system_id')->references('id')->on('billing_systems')->onDelete('restrict');
            $table->unsignedInteger('billing_cycle_id');
            $table->foreign('billing_cycle_id')->references('id')->on('billing_cycles')->onDelete('restrict');
            $table->unsignedInteger('payment_style_id');
            $table->foreign('payment_style_id')->references('id')->on('payment_styles')->onDelete('restrict');
            $table->unsignedInteger('payment_channel_id')->nullable();
            $table->foreign('payment_channel_id')->references('id')->on('payment_channels')->onDelete('restrict');
            $table->boolean('insured')->default(false);
            $table->unsignedInteger('sponsorship_type_id')->nullable();
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');
            $table->unsignedBigInteger('billing_sponsor_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');
            $table->unsignedBigInteger('sponsorship_policy_id')->nullable();
            $table->foreign('sponsorship_policy_id')->references('id')->on('sponsorship_policies')->onDelete('restrict');
            $table->dateTime('cancelled_date')->nullable();
            $table->uuid('canceller_id')->comment('The user who is cancelling the payment')->nullable();
            $table->foreign('canceller_id')->references('id')->on('users')->onDelete('restrict');
            $table->enum('status',['PENDING','PART-PAYMENT','FULL-PAYMENT','CANCELLED', 'ABSCOND','REFUNDED']);
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
        Schema::dropIfExists('service_orders');
    }
}
