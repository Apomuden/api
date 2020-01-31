<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRegNoColumnInPatientSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_sponsors', function (Blueprint $table) {
            if (Schema::hasColumn('patient_sponsors','reg_no')) {
                $table->string('member_id')->after('reg_no');
                $table->dropColumn('reg_no');
            }
            $table->uuid('user_id')->after('expiry_date');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_sponsors', function (Blueprint $table) {
            if (Schema::hasColumn('patient_sponsors','member_id')) {
                $table->string('reg_no')->after('member_id');
                $table->dropColumn('member_id');
            }
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

        });
    }
}