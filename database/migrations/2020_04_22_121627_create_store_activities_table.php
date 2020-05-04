<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->boolean('purchasing_from_suppliers')->default(false)->comment('A Store Activity that deals with purchasing from Suppliers');
            $table->boolean('receiving_from_suppliers')->default(false)->comment('A Store Activity that deals with Receiving Purchased Product from Suppliers');
            $table->boolean('issuing_requested_product')->default(false)->comment('Issuing Requested products to other stores/Departments');
            $table->boolean('requesting_products_from_stores')->default(false)->comment('Requesting product from Stores/Department from internal stores');
            $table->boolean('receiving_issued_products')->default(false)->comment('A Store Activity that deals with Receiving Issues Product from internal Stores');
            $table->boolean('direct_engagement_with_patient')->default(false)->comment('Store Activity that has direct engagement with patients');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->unique(['store_id','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_activities');
    }
}
