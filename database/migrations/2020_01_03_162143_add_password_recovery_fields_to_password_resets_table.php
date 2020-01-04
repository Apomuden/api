<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPasswordRecoveryFieldsToPasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->uuid('user_id')->after('email');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('recovered_at')->nullable()->after('expiry_date');
            $table->dateTime('updated_at')->nullable()->after('recovered_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropColumn('recovered_at');
            $table->dropColumn('updated_at');
        });
    }
}
