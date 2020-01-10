<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('consultation_given')->nullable();
            $table->UnsignedBigInteger('patient_id')->nullable();
            $table->uuid('user_id')->nullable(); //Specialist to which the consultation is assigned
            $table->UnsignedBigInteger('clinic_id')->nullable();
            $table->UnsignedBigInteger('service_price_id')->nullable();
            $table->dateTime('scheduled_for')->nullable()->useCurrent()->comment('The date for which the consultation service is scheduled');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
            $table->timestamps();
            /* Creating foreign key constraints */
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_price_id')->references('id')->on('service_prices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
