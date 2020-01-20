<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->unsignedBigInteger('billing_sponsor_id');
            $table->foreign('billing_sponsor_id')->references('id')->on('billing_sponsors')->onDelete('restrict');
            $table->unsignedBigInteger('sponsorship_policy_id')->nullable();
            $table->foreign('sponsorship_policy_id')->references('id')->on('sponsorship_policies')->onDelete('restrict');
            $table->unsignedInteger('priority')->comment('priority  number');
            $table->string('reg_no');
            $table->string('card_serial_no')->unique();
            $table->string('staff_name')->nullable();
            $table->string('staff_id')->nullable();
            $table->enum('benefit_type',['SELF','DEPENDANT','BABY'])->default('SELF');
            $table->unsignedInteger('relation_id');
            $table->foreign('relation_id')->references('id')->on('relationships')->onDelete('restrict');
            $table->date('issued_date');
            $table->date('expiry_date')->nullable();
            $table->enum('status',['ACTIVE','INACTIVE','TERMINATED','BLACKLISTED'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['patient_id','sponsorship_policy_id', 'billing_sponsor_id','deleted_at'],'unique_patient_sponsor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_sponsors');
    }
}
