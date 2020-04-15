<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_parameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('value_type',['Text','Number'])->default('Number');
            $table->string('unit');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->index();

            $table->timestamps();
            $table->softDeletes();
            $table->unique(['name','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lab_parameters');
    }
}
