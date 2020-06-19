<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObstetricHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obstetric_histories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');

            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('consultations')->onDelete('restrict');

            $table->unsignedInteger('patient_age');
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT'])->default('OUT-PATIENT');

            $table->unsignedInteger('gravida')->nullable()->default(0)
                ->comment('this is to indicate total number of pregnancies (full term, premature and abortions)');
            $table->unsignedInteger('full_term')->nullable()->default(0)
                ->comment('this is to indicate total number of births after 38 weeks gestation.');
            $table->unsignedInteger('premature')->nullable()->default(0)
                ->comment('this is to indicate total number of births before 38 weeks gestation.');
            $table->unsignedInteger('abortions')->nullable()->default(0)
                ->comment('this is to indicate total number of abortions (spontaneous and induced');
            $table->unsignedInteger('spontaneous')->nullable()->default(0)
                ->comment('this is to indicate total number of spontaneous pregnancies');
            $table->unsignedInteger('induced')->nullable()->default(0)
                ->comment('this is to indicate total number of induced pregnancies.');
            $table->unsignedInteger('multiple_birth')->nullable()->default(0)
                ->comment('this is to indicate total number of pregnancies resulting in multiple birth.');
            $table->unsignedInteger('living')->nullable()->default(0)
                ->comment('this is to indicate total number children still alive.');
            $table->unsignedInteger('deceased')->nullable()->default(0)
                ->comment('this is to indicate total number children not alive.');

            $table->uuid('user_id')->nullable()->comment('One who made the entry');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
            $table->unique(['patient_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obstetric_histories');
    }
}
