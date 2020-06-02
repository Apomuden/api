<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesConsultationComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_consultation_components', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('consultation_component_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('clinic_services')->onDelete('restrict');
            $table->foreign('consultation_component_id', 'consultation_component_foreign')->references('id')
                ->on('consultation_components')->onDelete('restrict');
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
        Schema::dropIfExists('services_consultation_components');
    }
}
