<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabServiceSampleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_service_sample_types', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('restrict');
            $table->unsignedBigInteger('lab_sample_type_id');
            $table->foreign('lab_sample_type_id')->references('id')->on('lab_sample_types')->onDelete('restrict');
            $table->unsignedInteger('order')->default(0)->index();
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
        Schema::dropIfExists('lab_service_sample_types');
    }
}
