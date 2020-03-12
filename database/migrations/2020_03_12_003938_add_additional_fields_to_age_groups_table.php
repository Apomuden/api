<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToAgeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('age_groups', function (Blueprint $table) {
            $table->enum('min_age_unit',['DAY','MONTH','YEAR'])->default('YEAR')->after('name');
            $table->enum('max_age_unit',['DAY','MONTH','YEAR'])->nullable()->after('name');
            $table->dropColumn('duration_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('age_groups', function (Blueprint $table) {
            $table->enum('duration_type',['YEAR','MONTH','DAY'])->default('YEAR');
            $table->dropColumn(['max_age_unit','min_age_unit']);
        });
    }
}
