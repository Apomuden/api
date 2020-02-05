<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable();
            $table->unsignedInteger('hospital_service_id');
            $table->foreign('hospital_service_id')->references('id')->on('hospital_services')->onDelete('restrict');
            $table->unsignedBigInteger('service_category_id');
            $table->foreign('service_category_id')->references('id')->on('service_categories')->onDelete('restrict');
            $table->unsignedBigInteger('service_subcategory_id')->nullable();
            $table->foreign('service_subcategory_id')->references('id')->on('service_subcategories')->onDelete('restrict');
            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
            $table->set('gender',['MALE','FEMALE','BIGENDER'])->default('MALE,FEMALE');
           /*  $table->unsignedInteger('funding_type_id')->nullable();
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict'); */
            $table->set('patient_status',['IN-PATIENT','OUT-PATIENT','WALK-IN'])->default('IN-PATIENT,OUT-PATIENT,WALK-IN');
            $table->decimal('amount',20,2)->default(0);
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['service_category_id', 'service_subcategory_id', 'age_group_id', 'gender', 'patient_status','deleted_at'], 'unique_service_price');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_prices');
    }
}
