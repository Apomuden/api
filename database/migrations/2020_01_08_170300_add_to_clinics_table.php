<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToClinicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clinics', function (Blueprint $table) {
            $table->unsignedBigInteger('service_price_id')->after('name')->nullable();
            $table->unsignedInteger('hospital_service_id')->after('name')->nullable();
            $table->foreign('service_price_id')
                ->references('id')
                ->on('service_prices')
                ->onDelete('cascade');
            $table->foreign('hospital_service_id')
                ->references('id')
                ->on('hospital_services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clinics', function (Blueprint $table) {
            $this->foreign(['service_price_id']);
            $this->foreign(['hospital_service_id']);
            $table->dropColumn('service_price_id');
            $table->dropColumn('hospital_service_id');
        });
    }
}
