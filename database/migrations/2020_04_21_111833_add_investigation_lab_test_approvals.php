<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvestigationLabTestApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investigations', function (Blueprint $table) {
            $table->uuid('approver_id')->comment('The user who approves investigation')->nullable()->after('user_id');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('approval_date')->after('approver_id')->nullable();
        });
        Schema::table('lab_test_samples', function (Blueprint $table) {
            $table->uuid('approver_id')->comment('The user who approves sample')->nullable()->after('user_id');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('approval_date')->after('approver_id')->nullable();
        });
        Schema::table('lab_test_results', function (Blueprint $table) {
            $table->uuid('approver_id')->comment('The user who approves results')->nullable()->after('user_id');
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('restrict');
            $table->dateTime('approval_date')->after('approver_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investigations', function (Blueprint $table) {
           $table->dropForeign(['approver_id']);
           $table->dropColumn('approver_id');
           $table->dropColumn('approval_date');
        });
        Schema::table('lab_test_samples', function (Blueprint $table) {
           $table->dropForeign(['approver_id']);
           $table->dropColumn('approver_id');
           $table->dropColumn('approval_date');
        });
        Schema::table('lab_test_results', function (Blueprint $table) {
           $table->dropForeign(['approver_id']);
           $table->dropColumn('approver_id');
           $table->dropColumn('approval_date');
        });
    }
}
