<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patient_id');
            $table->unsignedInteger('title_id');
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('restrict');
            $table->string('surname');
            $table->string('middlename')->nullable();
            $table->string('firstname');
            $table->string('photo')->nullable();
            $table->date('dob')->nullable();

            $table->enum('gender',['MALE','FEMALE']);
            $table->unsignedBigInteger('id_type_id')->nullable();
            $table->foreign('id_type_id')->references('id')->on('id_types')->onDelete('restrict');
            $table->string('id_no')->nullable()->unique();
            $table->boolean('id_expires')->nullable();
            $table->date('id_expiry_date')->nullable();
            $table->unsignedBigInteger('folder_id');
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('restrict');
            $table->string('old_folder_no')->nullable();
            $table->unsignedInteger('origin_country_id')->nullable();
            $table->foreign('origin_country_id')->references('id')->on('countries')->onDelete('restrict');
            $table->unsignedBigInteger('origin_region_id')->nullable();
            $table->foreign('origin_region_id')->references('id')->on('regions')->onDelete('restrict');
            $table->unsignedBigInteger('origin_district_id')->nullable();
            $table->foreign('origin_district_id')->references('id')->on('districts')->onDelete('restrict');
            $table->unsignedBigInteger('hometown_id')->nullable();
            $table->foreign('hometown_id')->references('id')->on('towns')->onDelete('restrict');


            $table->unsignedInteger('sponsorship_type_id')->nullable();
            $table->foreign('sponsorship_type_id')->references('id')->on('sponsorship_types')->onDelete('restrict');

            $table->unsignedInteger('funding_type_id')->nullable();
            $table->foreign('funding_type_id')->references('id')->on('funding_types')->onDelete('restrict');

            $table->unsignedInteger('billing_system_id')->nullable();
            $table->foreign('billing_system_id')->references('id')->on('billing_systems')->onDelete('restrict');
            $table->unsignedInteger('billing_cycle_id')->nullable();
            $table->foreign('billing_cycle_id')->references('id')->on('billing_cycles')->onDelete('restrict');
            $table->unsignedInteger('payment_style_id')->nullable();
            $table->foreign('payment_style_id')->references('id')->on('payment_styles')->onDelete('restrict');
            $table->unsignedInteger('payment_channel_id')->nullable();
            $table->foreign('payment_channel_id')->references('id')->on('payment_channels')->onDelete('restrict');

            $table->enum('marital',['SINGLE','MARRIED','DIVORCED','WIDOW','WIDOWER','OTHER'])->nullable();
            $table->unsignedInteger('religion_id')->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('restrict');
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->foreign('profession_id')->references('id')->on('professions')->onDelete('restrict');
            $table->string('staff_id')->nullable()->unique();
            $table->string('ssnit_no')->nullable()->unique();
            $table->mediumText('work_address')->nullable();
            $table->unsignedInteger('educational_level_id')->nullable();
            $table->foreign('educational_level_id')->references('id')->on('educational_levels')->onDelete('restrict');
            $table->unsignedInteger('native_lang_id')->nullable();
            $table->foreign('native_lang_id')->references('id')->on('languages')->onDelete('restrict');
            $table->unsignedInteger('second_lang_id')->nullable();
            $table->foreign('second_lang_id')->references('id')->on('languages')->onDelete('restrict');
            $table->unsignedInteger('official_lang_id')->nullable();
            $table->foreign('official_lang_id')->references('id')->on('languages')->onDelete('restrict');
            $table->mediumText('residence_address')->nullable();
            $table->unsignedBigInteger('active_cell')->nullable();
            $table->string('email')->nullable();
            $table->string('emerg_name')->nullable();
            $table->string('emerg_phone')->nullable();
            $table->unsignedInteger('emerg_relation_id')->nullable();
            $table->foreign('emerg_relation_id')->references('id')->on('relationships')->onDelete('restrict');
            $table->enum('mortality',['ALIVE','DEAD'])->default('ALIVE');
            $table->enum('reg_status',['IN-PATIENT','OUT-PATIENT','WALK-IN']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('patients');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
