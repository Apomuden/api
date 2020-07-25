<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('product_id');
            $table->string('batch_number')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->string('unit_of_measurement')->nullable();
            $table->unsignedBigInteger('opening_stock_quantity')->default(0);
            $table->unsignedBigInteger('original_quantity')->default(0);
            $table->unsignedBigInteger('quantity_remaining')->default(0);
            $table->decimal('unit_cost', 20, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('restrict');
            $table->unique(['product_id','store_id','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
