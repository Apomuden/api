<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFormUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_form_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE');
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
        Schema::dropIfExists('product_form_units');
    }
}