<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funding_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('sponsorship_type_id');
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');
            $table->unsignedInteger('billing_system_id');
            $table->foreign('billing_system_id')->references('id')->on('billing_systems')->onDelete('restrict');
            $table->unsignedInteger('billing_cycle_id');
            $table->foreign('billing_cycle_id')->references('id')->on('billing_cycles')->onDelete('restrict');
            $table->unsignedInteger('payment_style_id');
            $table->foreign('payment_style_id')->references('id')->on('payment_styles')->onDelete('restrict');
            $table->unsignedInteger('payment_channel_id');
            $table->foreign('payment_channel_id')->references('id')->on('payment_channels')->onDelete('restrict');
            $table->mediumText('description')->nullable();
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
        Schema::dropIfExists('funding_types');
    }
}
