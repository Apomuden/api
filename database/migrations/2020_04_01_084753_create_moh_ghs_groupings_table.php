<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMohGhsGroupingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moh_ghs_groupings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE')->index();
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
        Schema::dropIfExists('moh_ghs_groupings');
    }
}
