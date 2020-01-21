<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->unsignedInteger('age_group_id')->after('name')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
            $table->set('gender',['MALE','FEMALE','BIGENDER'])->default('MALE,FEMALE,BIGENDER')->after('age_group_id');
            $table->set('patient_status',['IN-PATIENT', 'OUT-PATIENT','WALK-IN'])->default('IN-PATIENT,OUT-PATIENT,WALK-IN')->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->dropForeign(['age_group_id']);
            $table->dropColumn(['age_group_id','gender','patient_status']);
        });
    }
}
