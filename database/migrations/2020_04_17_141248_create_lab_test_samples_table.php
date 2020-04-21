<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabTestSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_test_samples', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->string('sample_code');
            $table->unsignedBigInteger('lab_sample_type_id');
            $table->foreign('lab_sample_type_id')->references('id')->on('lab_sample_types')->onDelete('restrict');

            $table->unsignedBigInteger('investigation_id');
            $table->foreign('investigation_id')->references('id')->on('investigations')->onDelete('restrict');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');

            $table->uuid('technician_id');
            $table->foreign('technician_id')->references('id')->on('users')->onDelete('restrict');
            $table->uuid('user_id')->comment('one who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->enum('status', ['ACTIVE', 'INACTIVE','CANCELLED', 'APPROVED'])->default('ACTIVE');
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
        Schema::dropIfExists('lab_test_samples');
    }
}
