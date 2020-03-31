<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMohAgeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_categories', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('description')->nullable();
            $table->unsignedInteger('age_classification_id');
            $table->foreign('age_classification_id')->references('id')->on('age_classifications')->onDelete('restrict');
            $table->unsignedInteger('min_age');
            $table->enum('min_unit',['DAY','MONTH','YEAR'])->default('YEAR');
            $table->enum('min_comparator',['>','>=','=']);
            $table->unsignedInteger('max_age')->nullable();
            $table->enum('max_comparator',['<','<='])->nullable();
            $table->enum('max_unit',['DAY','MONTH','YEAR'])->default('YEAR');
            $table->unsignedInteger('age_group_id');
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['age_classification_id', 'min_age', 'min_comparator','age_group_id', 'max_age', 'max_comparator', 'max_unit','deleted_at'],'unique_age_categories');
            $table->unique(['description', 'age_classification_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('age_categories');
    }
}
