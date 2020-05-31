<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesConsultationQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_consultation_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('consultation_question_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('clinic_services')->onDelete('restrict');
            $table->foreign('consultation_question_id', 'consultation_question_foreign')->references('id')
                ->on('consultation_questions')->onDelete('restrict');
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
        Schema::dropIfExists('services_consultation_questions');
    }
}
