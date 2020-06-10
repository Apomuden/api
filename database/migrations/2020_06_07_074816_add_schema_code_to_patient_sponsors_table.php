<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchemaCodeToPatientSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_sponsors', function (Blueprint $table) {
            $table->string('schema_code')->nullable()->index()->after('card_serial_no');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_sponsors', function (Blueprint $table) {
            $table->dropIndex(['schema_code']);
            $table->dropColumn('schema_code');
        });
    }
}
