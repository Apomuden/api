<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicServicesConsultationQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_services_consultation_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_service_id');
            $table->unsignedBigInteger('consultation_question_id');
            $table->foreign('clinic_service_id', 'clinic_service_question_foreign')
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
