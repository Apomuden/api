<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requested_store_id');
            $table->unsignedBigInteger('issuing_store_id')->nullable();
            $table->timestamp('requisition_date')->useCurrent();
            $table->string('reference_number')->unique();
            $table->uuid('requested_by');
            $table->uuid('approved_by')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->decimal('expected_total_value', 20, 2)->default(0.00);
            $table->decimal('approved_total_value', 20, 2)->default(0.00);
            $table->enum('status',['PENDING','APPROVED','ISSUED','COMPLETED','CANCELLED','SUSPENDED'])->default('PENDING');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('issuing_store_id')->references('id')->on('stores')->onDelete('restrict');
            $table->foreign('requested_store_id')->references('id')->on('stores')->onDelete('restrict');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
