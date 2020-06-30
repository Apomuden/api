<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueAndReceiptVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_and_receipt_vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('issued_by');
            $table->unsignedBigInteger('issuing_store_id')->nullable();
            $table->string('requisition_reference_number');
            $table->unsignedBigInteger('requisition_id');
            $table->string('issued_voucher_number')->unique();
            $table->decimal('issued_total_value', 20, 2)->default(0.00);
            $table->timestamp('date_issued')->useCurrent();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('issued_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('issuing_store_id')->references('id')->on('stores')->onDelete('restrict');
            $table->foreign('requisition_reference_number')->references('reference_number')->on('requisitions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_and_receipt_vouchers');
    }
}
