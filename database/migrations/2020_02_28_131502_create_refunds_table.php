<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT', 'WALK-IN'])->default('OUT-PATIENT');
            $table->unsignedInteger('funding_type_id')->nullable();
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');
            $table->unsignedInteger('sponsorship_type_id');
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');
            $table->unsignedBigInteger('billing_sponsor_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');
            $table->unsignedBigInteger('patient_sponsor_id')->nullable();
            $table->foreign('patient_sponsor_id')->references('id')->on('patient_sponsors')->onDelete('restrict');
            $table->string('reference');
            $table->string('receipt_number')->nullable();
            $table->decimal('total_bill', 20, 2)->default(0);
            $table->decimal('refund_amount', 20, 2)->default(0);
            $table->decimal('balance', 20, 2)->default(0);
            $table->mediumText('reason')->nullable();
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
        Schema::dropIfExists('refunds');
    }
}
