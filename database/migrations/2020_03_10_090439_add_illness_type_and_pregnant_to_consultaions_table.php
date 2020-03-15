<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIllnessTypeAndPregnantToConsultaionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->boolean('pregnant')->after('consultant_id')->default(false);
            $table->unsignedInteger('illness_type_id')->after('pregnant')->nullable();
            $table->foreign('illness_type_id')->references('id')->on('illness_types')->onDelete('restrict');
            $table->unsignedBigInteger('consulting_room_id')->after('illness_type_id')->nullable();
            $table->foreign('consulting_room_id')->references('id')->on('consulting_rooms')->onDelete('restrict');
            $table->unsignedInteger('discharge_reason_id')->after('consulting_room_id')->nullable();
            $table->foreign('discharge_reason_id')->references('id')->on('discharge_reasons')->onDelete('restrict');
            $table->dateTime('review_date')->after('discharge_reason_id')->nullable();
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
           $table->dropForeign(['illness_type_id']);
           $table->dropForeign(['consulting_room_id']);
           $table->dropForeign(['discharge_reason_id']);
           $table->dropColumn(['pregnant', 'illness_type_id', 'consulting_room_id', 'discharge_reason_id', 'review_date']);
        });
    }
}
