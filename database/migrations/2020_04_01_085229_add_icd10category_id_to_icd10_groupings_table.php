<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIcd10categoryIdToIcd10GroupingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icd10_groupings', function (Blueprint $table) {
            $table->string('icd10_grouping_code')->after('name')->nullable();
            $table->unsignedBigInteger('icd10_category_id')->nullable()->after('name');
            $table->foreign('icd10_category_id')->references('id')->on('icd10_categories')->onDelete('restrict');
            $table->unique(['icd10_grouping_code','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icd10_groupings', function (Blueprint $table) {
            $table->dropForeign(['icd10_category_id']);
            $table->dropColumn('icd10_category_id');

            $table->dropUnique(['icd10_grouping_code', 'deleted_at']);
            $table->dropColumn('icd10_grouping_code');
        });
    }
}
