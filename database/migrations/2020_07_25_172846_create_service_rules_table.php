<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->set('patient_status', ['IN-PATIENT', 'OUT-PATIENT', 'WALK-IN'])->default('IN-PATIENT,OUT-PATIENT,WALK-IN');
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
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
        Schema::dropIfExists('service_rules');
    }
}
