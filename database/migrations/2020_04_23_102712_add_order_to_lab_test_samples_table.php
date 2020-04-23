<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderToLabTestSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_test_samples', function (Blueprint $table) {
            $table->unsignedInteger('lab_sample_type_order')->default(0)->after('lab_sample_type_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_test_samples', function (Blueprint $table) {
            $table->dropIndex(['lab_sample_type_order']);
            $table->dropColumn('lab_sample_type_order');
        });
    }
}
