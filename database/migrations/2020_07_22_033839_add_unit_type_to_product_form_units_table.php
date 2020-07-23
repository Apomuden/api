<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitTypeToProductFormUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_form_units', function (Blueprint $table) {
            $table->enum('unit_type',['BASE','VOLUME'])->default('BASE')->after('name');
            $table->dropUnique(['name','deleted_at']);
            $table->index(['name','unit_type','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_form_units', function (Blueprint $table) {
            $table->dropIndex(['name','unit_type','deleted_at']);
            $table->index(['name','deleted_at']);
            $table->dropColumn('unit_type');
        });
    }
}
