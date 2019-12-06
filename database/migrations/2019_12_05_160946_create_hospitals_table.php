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
            $table->string('staff_id_prefix');
            $table->string('staff_id_seperator')->default('-');
            $table->string('folder_id_prefix')->default('-');
            $table->string('folder_id_seperator');
            $table->set('folder_type',['INDIVIDUAL','FAMILY'])->default('INDIVIDUAL');
            $table->set('consultation_type',['INDIVIDUAL','FAMILY'])->default('INDIVIDUAL');
            $table->set('payment_style',['PREPAID','POSTPAID'])->default('PREPAID');
            $table->enum('discount_type',['ABSOLUTE','PERCENTAGE'])->default('ABSOLUTE');
            $table->decimal('non_credit_discount',20,2)->default(0);
            $table->unsignedInteger('hours_of_consultation')->default('24');
            $table->set('payment_channels',['CASH','MOMO','POS','CHEQUE','BANK_DEPOSIT'])->default('CASH,MOMO');
            $table->set('installment_type',['FULL_PAYMENT','PART_PAYMENT','DEPOSIT','CREDIT'])->default('FULL_PAYMENT,CREDIT');
            $table->boolean('set_appointment')->default(false)->comment('Can Records set appointment');
            $table->unsignedInteger('phone1');
            $table->unsignedInteger('phone2')->nullable();
            $table->string('email1');
            $table->string('email2')->nullable();
            $table->mediumText('postal_address')->nullable();
            $table->mediumText('physical_address')->nullable();
            $table->string('gps_location')->nullable();
            $table->unsignedInteger('accreditation_id')->nullable();
            $table->foreign('accreditation_id')->references('id')->on('accreditations')->onDelete('restrict');
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
