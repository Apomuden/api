<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question');
            $table->set('gender', ['MALE', 'FEMALE'])->default('MALE,FEMALE');
            $table->enum('value_type', ['Text', 'Number', 'True/False', 'Select'])->default('Text');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['question', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultation_questions');
    }
}
