<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->string('disease_code')->nullable()->index();
            $table->string('icd10_code')->index();
            $table->string('icd10_grouping_code')->index();

            $table->string('adult_gdrg')->nullable();
            $table->unsignedDecimal('adult_tariff',20,2)->default(0.00);
            $table->string('child_gdrg')->nullable();
            $table->unsignedDecimal('child_tariff', 20, 2)->default(0.00);




            $table->unsignedBigInteger('icd10_grouping_id');
            $table->foreign('icd10_grouping_id')->references('id')->on('icd10_groupings')->onDelete('restrict');

            $table->unsignedBigInteger('icd10_category_id');
            $table->foreign('icd10_category_id')->references('id')->on('icd10_categories')->onDelete('restrict');

            $table->unsignedBigInteger('moh_ghs_grouping_id');
            $table->foreign('moh_ghs_grouping_id')->references('id')->on('moh_ghs_groupings')->onDelete('restrict');

            $table->string('moh_grouping_code')->index();

            $table->unsignedInteger('illness_type_id');
            $table->foreign('illness_type_id')->references('id')->on('illness_types')->onDelete('restrict');

            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE')->index();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['name','deleted_at']);
            $table->unique(['icd10_code','deleted_at']);
            $table->unique(['icd10_grouping_code','deleted_at']);
            $table->unique(['moh_grouping_code','deleted_at']);
            $table->unique(['disease_code','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diseases');
    }
}
