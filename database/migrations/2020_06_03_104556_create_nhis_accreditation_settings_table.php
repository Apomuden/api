<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNhisAccreditationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhis_accreditation_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nhis_provider_level_id')->nullable();
            $table->foreign('nhis_provider_level_id')->references('id')->on('nhis_provider_levels')->onDelete('restrict');
            $table->string('nhis_authorization_code')->nullable();
            $table->string('nhis_provider_no')->nullable();
            $table->enum('nhis_claim_submission_mode', ['PRINTING', 'ELECTRONIC'])->nullable();
            $table->string('claim_manager_name')->nullable();
            $table->string('claim_manager_signature')->nullable();
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
        Schema::dropIfExists('nhis_accreditation_settings');
    }
}
