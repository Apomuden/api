<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNhisSettingsToHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->unsignedBigInteger('nhis_provider_level_id')->nullable()->after('name');
            $table->foreign('nhis_provider_level_id')->references('id')->on('nhis_provider_levels')->onDelete('restrict');
            $table->string('nhis_authorization_code')->nullable()->after('ownership_type');
            $table->string('nhis_provider_no')->nullable()->after('nhis_authorization_code');
            $table->enum('nhis_claim_submission_mode',['PRINTING', 'ELECTRONIC'])->nullable()->after('nhis_provider_no');
            $table->string('claim_manager_name')->nullable()->after('nhis_claim_submission_mode');
            $table->string('claim_manager_signature')->nullable()->after('claim_manager_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn('nhis_provider_level_id');
            $table->dropColumn('nhis_authorization_code');
            $table->dropColumn('nhis_provider_no');
            $table->dropColumn('nhis_claim_submission_mode');
            $table->dropColumn('claim_manager_name');
            $table->dropColumn('claim_manager_signature');
        });
    }
}
