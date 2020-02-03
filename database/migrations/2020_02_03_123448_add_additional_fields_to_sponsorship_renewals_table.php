<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToSponsorshipRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsorship_renewals', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_sponsor_id')->after('billing_sponsor_id')->nullable();
            $table->foreign('patient_sponsor_id')->references('id')->on('patient_sponsors')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sponsorship_renewals', function (Blueprint $table) {
            $table->dropForeign(['patient_sponsor_id']);
            $table->dropColumn('patient_sponsor_id');
        });
    }
}
