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
            $table->enum('age',['ALL','CHILD','ADULT'])->default('ALL');
            $table->enum('gender',['ALL','MALE','FEMALE'])->default('ALL');
            $table->enum('patient_status',['ALL','OUT','IPD'])->default('ALL');
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
            //
        });
    }
}
