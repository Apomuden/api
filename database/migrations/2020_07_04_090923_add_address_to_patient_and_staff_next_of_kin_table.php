<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToPatientAndStaffNextOfKinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_next_of_kin', function (Blueprint $table) {
            $table->mediumText('address')->after('email')->nullable();
        });
        Schema::table('staff_next_of_kin', function (Blueprint $table) {
            $table->mediumText('address')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_next_of_kin', function (Blueprint $table) {
           $table->dropColumn('address');
        });
        Schema::table('staff_next_of_kin', function (Blueprint $table) {
           $table->dropColumn('address');
        });
    }
}
