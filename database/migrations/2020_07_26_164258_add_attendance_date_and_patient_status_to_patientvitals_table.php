<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttendanceDateAndPatientStatusToPatientvitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patientvitals', function (Blueprint $table) {
            //$table->enum('patient_status', ['IN-PATIENT', 'OUT-PATIENT'])->default('OUT-PATIENT')->nullable()->index()->after('patient_id');
            $table->dateTime('attendance_date')->nullable()->index()->after('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patientvitals', function (Blueprint $table) {
            //$table->dropIndex(['patient_status']);
            //$table->dropColumn('patient_status');
            $table->dropIndex(['attendance_date']);
            $table->dropColumn('attendance_date');
        });
    }
}
