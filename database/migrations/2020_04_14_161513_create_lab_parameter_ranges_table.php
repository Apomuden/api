<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabParameterRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_parameter_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lab_parameter_id');
            $table->foreign('lab_parameter_id')->references('id')->on('lab_parameters')->onDelete('restrict');
            $table->string('flag')->nullable();
            $table->enum('min_comparator',['>', '>=','<','<=', '='])->nullable();
            $table->unsignedDecimal('min_value',10,2)->nullable();
            $table->enum('max_comparator',['>', '>=','<','<=', '='])->nullable();
            $table->unsignedDecimal('max_value',10,2)->nullable();

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->index();

            $table->unsignedInteger('min_age')->nullable();
            $table->enum('min_age_unit',['DAY', 'WEEK', 'MONTH', 'YEAR'])->nullable();

            $table->unsignedInteger('max_age')->nullable();
            $table->enum('max_age_unit',['DAY', 'WEEK', 'MONTH', 'YEAR'])->nullable();

            $table->set('gender',['MALE','FEMALE'])->default('MALE,FEMALE');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['flag', 'lab_parameter_id', 'min_age', 'min_age_unit', 'max_age', 'max_age_unit','gender','deleted_at'],'Unique_lab_param_range');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_parameter_ranges');
    }
}
