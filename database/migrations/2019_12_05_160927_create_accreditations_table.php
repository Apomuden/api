<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\In;

class CreateAccreditationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accreditations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reg_body')->index();
            $table->string('reg_no')->index();
            $table->date('reg_date')->index();
            $table->string('tin')->index();
            $table->date('expiry_date')->index();
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE')->index();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['reg_no', 'reg_date','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accreditations');
    }
}
