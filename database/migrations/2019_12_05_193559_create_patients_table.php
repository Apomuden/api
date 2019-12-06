<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('title_id');
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('restrict');
            $table->string('surname');
            $table->string('middlename')->nullable();
            $table->string('firstname');
            $table->date('dob')->nullable();
            $table->enum('gender',['MALE','FEMALE']);
            $table->unsignedInteger('funding_type_id');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');
            $table->enum('marital',['SINGLE','MARRIED','DIVORCED','WIDOW','WIDOWER','OTHER']);
            $table->unsignedInteger('religion_id')->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('restrict');
            $table->string('occupation')->nullable();
            $table->unsignedInteger('educational_level_id')->nullable();
            $table->foreign('educational_level_id')->references('id')->on('educational_levels')->onDelete('restrict');
            $table->mediumText('residence')->nullable();
            $table->unsignedInteger('active_cell')->nullable();
            $table->string('email')->nullable();
            $table->string('emerg_fullname');
            $table->string('emerg_phone');
            $table->unsignedInteger('emerg_relation_id');
            $table->foreign('emerg_relation_id')->references('id')->on('relationships')->onDelete('restrict');
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
        Schema::dropIfExists('patients');
    }
}
