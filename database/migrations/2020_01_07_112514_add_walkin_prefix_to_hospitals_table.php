<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalkinPrefixToHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->string('walkin_prefix',5)->after('year_digits')->nullable();
            $table->enum('walkin_id_type',['AUTOGENERATE','MANUAL'])->after('walkin_prefix')->default('AUTOGENERATE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn('walkin_prefix');
            $table->dropColumn('walkin_id_type');
        });
    }
}
