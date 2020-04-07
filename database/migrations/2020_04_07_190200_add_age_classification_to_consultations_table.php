<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgeClassificationToConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->unsignedInteger('age_class_id')->nullable();
            $table->foreign('age_class_id')->references('id')->on('age_classifications')->onDelete('restrict');
            $table->unsignedInteger('age_category_id')->nullable();
            $table->foreign('age_category_id')->references('id')->on('age_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropForeign(['age_class_id']);
            $table->dropColumn('age_class_id');
            $table->dropForeign(['age_category_id']);
            $table->dropColumn('age_category_id');
        });
    }
}
