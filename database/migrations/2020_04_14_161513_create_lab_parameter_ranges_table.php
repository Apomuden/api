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
            $table->enum('min_comparator',['>', '>=','<','<=', '='])->default('<=');
            $table->unsignedDecimal('min_value',10,2)->default(0.00);
            $table->enum('max_comparator',['>', '>=','<','<=', '='])->nullable();
            $table->unsignedDecimal('max_value',10,2)->nullable();

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->index();

            $table->unsignedInteger('min_age')->default(0);
            $table->
            $table->unsignedInteger('age_group_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');

            $table->set('gender',['MALE','FEMALE'])->default('MALE,FEMALE');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['flag', 'lab_parameter_id', 'age_group_id','gender'],'Unique_lab_param_range');
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
