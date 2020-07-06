<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceOrderableFieldsToServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_orders', function (Blueprint $table) {
            $table->string('service_orderable_type')->after('patient_status')->index()->nullable();
            $table->string('service_orderable_id')->after('service_orderable_type')->index()->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_orders', function (Blueprint $table) {
           $table->dropIndex(['service_orderable_type']);
           $table->dropColumn('service_orderable_type');
           $table->dropIndex(['service_orderable_id']);
           $table->dropColumn('service_orderable_id');
        });
    }
}
