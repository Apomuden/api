<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRegNoColumnToMemberIdInSponsorshipRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sponsorship_renewals', function (Blueprint $table) {
            if (Schema::hasColumn('sponsorship_renewals','reg_no')) {
                $table->string('member_id')->nullable()->after('reg_no');
                $table->dropColumn('reg_no');
            }
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
            if (Schema::hasColumn('sponsorship_renewals','member_id')) {
                $table->string('reg_no')->nullable()->after('member_id');
                $table->dropColumn('member_id');
            }
        });
    }
}
