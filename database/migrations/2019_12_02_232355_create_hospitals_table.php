<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->unsignedInteger('phone1');
            $table->unsignedInteger('phone2')->nullable();
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->mediumText('postal_address')->nullable();
            $table->mediumText('physical_address')->nullable();
            $table->string('gps_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospitals');
    }
}
