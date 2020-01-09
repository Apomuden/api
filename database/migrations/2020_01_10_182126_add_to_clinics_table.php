<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->enum('age',['ALL','CHILD','ADULT'])->default('ALL')->after('name');
            $table->enum('gender',['ALL','MALE','FEMALE'])->default('ALL')->after('age');
            $table->enum('patient_status',['ALL','OUT','IPD'])->default('ALL')->after('gender');
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
            $table->dropColumn(['age','gender','patient_status']);
        });
    }
}
