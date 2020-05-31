<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('adjustment_type',['OPENING','OPERATIONAL'])->default('OPERATIONAL');
            $table->unsignedBigInteger('store_id');
            $table->string('reference_number')->unique();
            $table->mediumText('description')->nullable();
            $table->enum('status',['PENDING','APPROVED','CANCELLED','SUSPENDED'])->default('PENDING');
            $table->uuid('requested_by');
            $table->uuid('approved_by')->nullable();
            $table->timestamp('adjustment_date')->useCurrent();
            $table->timestamp('approval_date')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('store_id')->references('id')->on('stores')->onDelete('restrict');
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
        Schema::dropIfExists('stock_adjustments');
    }
}
