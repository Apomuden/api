<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('generic_name');
            $table->string('brand_name');
            $table->unsignedBigInteger('product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->unsignedBigInteger('product_form_id')->nullable();
            $table->foreign('product_form_id')->references('id')->on('product_forms')->onDelete('cascade');
            $table->unsignedBigInteger('product_form_unit_id')->nullable();
            $table->foreign('product_form_unit_id')->references('id')->on('product_form_units')->onDelete('cascade');
            $table->unsignedBigInteger('medicine_route_id')->nullable();
            $table->foreign('medicine_route_id')->references('id')->on('medicine_routes')->onDelete('cascade');
            $table->string('minimum_form_issue_unit')->nullable();
            $table->string('default_minimum_dosage')->nullable();
            $table->string('package_maximum_issue')->nullable();
            $table->string('strength_equivalent')->nullable();
            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('cascade');
            $table->enum('gender',['MALE','FEMALE','BOTH'])->default('BOTH');
            $table->enum('nhis_cover',['YES','NO'])->default('YES');
            $table->string('nhis_code')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->enum('expires',['YES','NO'])->default('YES');
            $table->timestamp('expiry_date')->nullable();
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
        Schema::dropIfExists('products');
    }
}
