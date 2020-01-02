<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('logo')->nullable();
            $table->string('staff_id_prefix',5)->nullable();
            $table->string('staff_id_seperator',2)->nullable()->default('-');
            $table->string('folder_id_prefix',5)->nullable();
            $table->string('folder_id_seperator',2)->nullable();
            $table->unsignedInteger('digits_after_staff_prefix')->default(4);
            $table->unsignedInteger('digits_after_folder_prefix')->default(4);
            $table->unsignedInteger('year_digits')->nullable()->default(2);
            $table->set('allowed_folder_type',['INDIVIDUAL','FAMILY'])->default('INDIVIDUAL,FAMILY');
            $table->set('allowed_installment_type',['FULL_PAYMENT','PART_PAYMENT','DEPOSIT','CREDIT'])->default('FULL_PAYMENT,CREDIT');
            $table->unsignedBigInteger('active_cell');
            $table->unsignedBigInteger('alternate_cell')->nullable();
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->mediumText('postal_address')->nullable();
            $table->mediumText('physical_address')->nullable();
            $table->string('gps_location')->nullable();
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
        Schema::dropIfExists('hospitals');
    }
}
