<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            //$table->unsignedInteger('sponsorship_type_id');
            //$table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');
            //$table->unsignedBigInteger('company_id');
            //$table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
            $table->enum('status',['ACTIVE','INACTIVE','TERMINATED','BLACKLISTED'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            //$table->unique(['name','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_sponsors');
    }
}
