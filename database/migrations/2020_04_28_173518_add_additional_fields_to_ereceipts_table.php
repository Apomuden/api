<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToEreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ereceipts', function (Blueprint $table) {
            $table->enum('status',['FULL-PAYMENT','PART-PAYMENT','ABSCOND','REFUNDED'])->default('FULL-PAYMENT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ereceipts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
