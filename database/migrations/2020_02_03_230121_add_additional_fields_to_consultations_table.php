<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() : void
    {
        Schema::table('consultations', static function (Blueprint $table) {
            $table->unsignedBigInteger('billing_sponsor_id')->after('patient_id')->nullable();
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');
            $table->string('member_id')->after('patient_id')->nullable();
            $table->string('staff_id')->after('member_id')->nullable();
            $table->string('card_serial_no')->after('staff_id')->nullable();
            $table->string('ccc', 5)->unique()->after('member_id')->nullable()->comment('Claim Check Code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() : void
    {
        Schema::table('consultations', static function (Blueprint $table) {
            $table->dropForeign(['billing_sponsor_id']);
            $table->dropColumn(['ccc','member_id','staff_id','card_serial_no']);
        });
    }
}
