<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddThirdpartyRefAndPaymentChannelAndBankToEreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ereceipts', function (Blueprint $table) {
           // $table->string('api_thirdparty_ref')->after('amount_paid')->index()->nullable();
            $table->string('api_internal_ref')->after('amount_paid')->index()->nullable();
            $table->string('payee_transaction_id')->after('api_internal_ref')->index()->nullable();
            $table->string('payee_account_no')->after('payee_transaction_id')->index()->nullable();

            $table->unsignedInteger('payment_channel_id')->after('payee_account_no')->nullable()->after('payee_account_no');
            $table->foreign('payment_channel_id')->references('id')->on('payment_channels')->onDelete('restrict');

            $table->unsignedInteger('bank_id')->after('payment_channel_id')->nullable()->after('amount_paid');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('restrict');

            $table->string('cheque_no')->nullable()->after('bank_id')->index();
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
            //$table->dropIndex(['api_thirdparty_ref']);
            //$table->dropColumn('api_thirdparty_ref');

            $table->dropIndex(['api_internal_ref']);
            $table->dropColumn('api_internal_ref');

            $table->dropIndex(['payee_transaction_id']);
            $table->dropColumn('payee_transaction_id');

            $table->dropIndex(['payee_account_no']);
            $table->dropColumn('payee_account_no');

            $table->dropForeign(['payment_channel_id']);
            $table->dropColumn('payment_channel_id');

            $table->dropForeign(['bank_id']);
            $table->dropColumn('bank_id');

            $table->dropIndex(['cheque_no']);
            $table->dropColumn('cheque_no');
        });
    }
}
