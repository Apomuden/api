<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssuedDetailsFieldsToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->string('issued_voucher_number')->unique()->nullable()->after('reference_number');
            $table->foreign('issued_voucher_number')->references('issued_voucher_number')->on('issue_and_receipt_vouchers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropForeign(['issued_voucher_number']);
            $table->dropColumn('issued_voucher_number');
        });
    }
}
