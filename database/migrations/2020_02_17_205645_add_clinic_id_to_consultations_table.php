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
            $table->unsignedBigInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('restrict');
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
