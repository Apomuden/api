<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('folder_no');
            $table->string('rack_no')->nullable();
            $table->enum('folder_type',['INDIVIDUAL','FAMILY'])->default('INDIVIDUAL');
            $table->enum('status',['ACTIVE','INACTIVE','NULLIFIED','OLD'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['folder_no','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('folders');
        Schema::enableForeignKeyConstraints();
    }
}
