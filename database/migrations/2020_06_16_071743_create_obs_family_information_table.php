<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObsFamilyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obs_family_information', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedInteger('patient_age');
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT'])->default('OUT-PATIENT');

            $table->string('partner_name');
            $table->date('partner_dob')->nullable();

            $table->unsignedBigInteger('partner_region_id')->nullable();
            $table->foreign('partner_region_id')->references('id')->on('regions')->onDelete('restrict');

            $table->unsignedBigInteger('partner_district_id')->nullable();
            $table->foreign('partner_district_id')->references('id')->on('districts')->onDelete('restrict');

            $table->string('partner_residence')->nullable();
            $table->string('partner_phone');

            $table->unsignedInteger('partner_educational_level_id')->nullable();
            $table->foreign('partner_educational_level_id')->references('id')->on('educational_levels')->onDelete('restrict');

            $table->string('partner_occupation')->nullable();

            $table->string('ice_name');
            $table->string('ice_phone');
            $table->string('ice_driver_phone')->nullable();

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
            $table->unique(['patient_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obs_family_information');
    }
}
