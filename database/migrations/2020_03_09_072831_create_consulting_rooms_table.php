<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultingRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulting_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->set('gender',['MALE','FEMALE','BIGENDER'])->default('MALE,FEMALE,BIGENDER');
            $table->enum('status',['ACTIVE','INACTIVE']);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['description','gender','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulting_rooms');
    }
}
