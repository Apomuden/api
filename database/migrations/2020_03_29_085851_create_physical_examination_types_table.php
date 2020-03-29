<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalExaminationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_examination_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('physical_examination_category_id');
            $table->foreign('physical_examination_category_id', 'physical_exam_category_id')->references('id')->on('physical_examination_categories')->onDelete('restrict');
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name', 'physical_examination_category_id'],'unique_physical_exam_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physical_examination_types');
    }
}
