<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeServiceAndProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_service_and_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('serviceable', 'episode_service_product_type_id');
            $table->unsignedDecimal('serviceable_fee',20,2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('episode_service_and_products');
    }
}
