<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUserRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_remarks', function (Blueprint $table) {
            $table->enum('status',['ACTIVE','INACTIVE'])->after('remarker_id')->default('ACTIVE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_remarks', function (Blueprint $table) {
           $table->dropColumn('status');
        });
    }
}
