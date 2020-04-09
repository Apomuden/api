<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeGroupIdToDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->unsignedInteger('age_group_id')->after('illness_type_id')->nullable();
            $table->foreign('age_group_id')->references('id')->on('age_groups')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diseases', function (Blueprint $table) {
          $table->dropForeign(['age_group_id']);
          $table->dropColumn('age_group_id');
        });
    }
}
