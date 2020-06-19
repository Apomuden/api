<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObstetricQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obstetric_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question');

            $table->unsignedInteger('order')->default(0);
            $table->enum('step', ['Infant Feeding', 'Menstrual History', 'Current Pregnancy']);

            $table->enum('value_type', ['Text', 'Number', 'True/False', 'Select'])->default('Text');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['question', 'deleted_at']);
            $table->unique(['order', 'step'], 'unique_order_step');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obstetric_questions');
    }
}

// php artisan generate:apifiles ObstetricQuestion --table=obstetric_questions && php artisan generate:apifiles ObstetricQuestionOption --table=obstetric_question_options && php artisan generate:apifiles ObstetricQuestionResponse --table=obstetric_question_responses
