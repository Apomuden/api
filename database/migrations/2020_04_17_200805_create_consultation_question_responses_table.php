<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation_question_responses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_question_id');
            $table->foreign('consultation_question_id')->references('id')->on('consultation_questions')->onDelete('restrict');

            $table->uuid('consultant_id')->nullable()->comment('One who made the entry');
            $table->foreign('consultant_id')->references('id')->on('users')->onDelete('restrict');

            $table->string('response')->nullable();
            $table->dateTime('response_date')->nullable();

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
        Schema::dropIfExists('consultation_question_responses');
    }
}
