<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('restrict');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('restrict');
            $table->unsignedBigInteger('product_form_unit_id')->nullable();
            $table->foreign('product_form_unit_id')->references('id')->on('product_form_units')->onDelete('restrict');
            $table->unsignedDecimal('current_unit_cost',20,2)->default(0.00);
            $table->unsignedDecimal('previous_unit_cost',20,2)->default(0.00);
            $table->unsignedDecimal('variance_unit_cost',20,2)->default(0.00);
            $table->unsignedDecimal('prepaid_amount',20,2)->default(0.00);
            $table->unsignedDecimal('postpaid_amount',20,2)->default(0.00);
            $table->unsignedDecimal('nhis_amount',20,2)->default(0.00);

            $table->uuid('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('restrict');

            $table->uuid('updated_by_id')->nullable();
            $table->foreign('updated_by_id')->references('id')->on('users')->onDelete('restrict');

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
        Schema::dropIfExists('product_prices');
    }
}
