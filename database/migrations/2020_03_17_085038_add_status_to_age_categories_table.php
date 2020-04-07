<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAgeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('age_categories', function (Blueprint $table) {
            $table->enum('status',['ACTIVE','INACTIVE'])->default('ACTIVE')->after('age_group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('age_categories', function (Blueprint $table) {
          $table->dropColumn('status');
        });
    }
}
