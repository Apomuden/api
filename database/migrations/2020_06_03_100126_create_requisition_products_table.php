<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->string('batch_number')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->string('unit_of_measurement')->nullable();
            $table->unsignedBigInteger('issuer_quantity_at_hand')->nullable()->comment('Quantity of the product at the store at the time of approval');
            $table->unsignedBigInteger('requester_quantity_at_hand')->nullable()->comment('Quantity of the product at the store at the time of requisition');
            $table->unsignedBigInteger('requested_quantity')->default(0);
            $table->unsignedBigInteger('approved_quantity')->default(0);
            $table->decimal('unit_cost', 20, 2)->default(0.00);
            $table->decimal('expected_value', 20, 2)->default(0.00);
            $table->decimal('approved_expected_value', 20, 2)->default(0.00);
            $table->string('reference_number');
            $table->mediumText('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('reference_number')->references('reference_number')->on('stock_adjustments')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisition_products');
    }
}
