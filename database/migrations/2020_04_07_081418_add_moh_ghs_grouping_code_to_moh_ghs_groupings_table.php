<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMohGhsGroupingCodeToMohGhsGroupingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('moh_ghs_groupings', function (Blueprint $table) {
            $table->string('moh_grouping_code')->after('name')->nullable();
            $table->unique(['moh_grouping_code', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moh_ghs_groupings', function (Blueprint $table) {
            $table->dropUnique(['moh_grouping_code', 'deleted_at']);
            $table->dropColumn('moh_grouping_code');
        });
    }
}
