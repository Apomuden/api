<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGenericNameForProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_generic_names', function (Blueprint $table) {
            $table->dropColumn('generic_name');
            $table->unsignedBigInteger('generic_name_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('product_generic_names', function (Blueprint $table) {
            $table->dropColumn('generic_name_id');
            $table->string('generic_name');
        });
    }
}
