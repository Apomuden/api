<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddMakeReceiptNumberNullableAndAddInvoiceNumberToEreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ereceipts', function (Blueprint $table) {
            DB::statement('ALTER TABLE `ereceipts` CHANGE `receipt_number` `receipt_number` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;');
            $table->string('invoice_number')->after('patient_status')->index()->nullable();
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
            DB::statement('ALTER TABLE `ereceipts` CHANGE `receipt_number` `receipt_number` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;');
            $table->dropIndex(['invoice_number']);
            $table->dropColumn('invoice_number');
        });
    }
}
