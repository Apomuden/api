<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_documents', function (Blueprint $table) {
            $table->enum('status',['ACTIVE','INACTIVE'])->after('file')->default('ACTIVE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_documents', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
