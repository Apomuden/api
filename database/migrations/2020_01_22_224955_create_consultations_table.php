<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('consultation_given');
            $table->unsignedInteger('service_quantity')->default(1);
            $table->unsignedDecimal('service_fee', 20, 2)->default(0.00);
            $table->unsignedBigInteger('patient_id');
            $table->unsignedInteger('funding_type_id');
            $table->unsignedInteger('sponsorship_type_id');
            $table->unsignedInteger('age_group_id');
            $table->unsignedInteger('age');
            $table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT']);
            $table->unsignedBigInteger('consultation_service_id');
            $table->uuid('user_id')->nullable()->comment('The doctor to whom the consultation service is assigned');
            $table->enum('order_type', ['INTERNAL', 'EXTERNAL'])->default('INTERNAL');
            $table->dateTime('attendance_date')->useCurrent();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('INACTIVE');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('restrict');
            $table->foreign('consultation_service_id')->references('id')->on('clinic_consult_services')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
}
