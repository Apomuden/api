<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClinicIdToConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_id')->after('id');
            $table->unsignedInteger('clinic_type_id')->after('id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
            $table->foreign('clinic_type_id')->references('id')->on('clinic_types')->onDelete('restrict');
            //$table->unique(['consultation_given','deleted_at']);
            //$table->unique(['age_group_id', 'gender', 'patient_status','deleted_at'], 'unique_consultation_service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });
    }
}
