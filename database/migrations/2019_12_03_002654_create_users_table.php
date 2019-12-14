<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('staff_id')->unique();
            $table->unsignedInteger('title_id');
            $table->foreign('title_id')->references('id')->on('titles')->onDelete('restrict');
            $table->string('surname');
            $table->string('middlename')->nullable();
            $table->string('firstname');
            $table->date('dob')->nullable();
            $table->enum('gender',['MALE','FEMALE']);
            $table->unsignedBigInteger('id_type_id')->nullable();
            $table->foreign('id_type_id')->references('id')->on('id_types')->onDelete('restrict');
            $table->string('id_no')->nullable()->unique();
            $table->unsignedInteger('role_id')->index();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->unsignedInteger('religion_id')->nullable();
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('restrict');

            $table->unsignedInteger('educational_level_id')->nullable();
            $table->foreign('educational_level_id')->references('id')->on('educational_levels')->onDelete('restrict');
            $table->mediumText('residence');

            $table->unsignedInteger('origin_country_id')->nullable();
            $table->foreign('origin_country_id')->references('id')->on('countries')->onDelete('restrict');

            $table->unsignedBigInteger('origin_region_id')->nullable();
            $table->foreign('origin_region_id')->references('id')->on('regions')->onDelete('restrict');

            $table->unsignedBigInteger('hometown_id')->nullable();
            $table->foreign('hometown_id')->references('id')->on('towns')->onDelete('restrict');

            $table->enum('marital',['SINGLE','MARRIED','DIVORCED','WIDOW','WIDOWER','OTHER']);
            $table->unsignedBigInteger('active_cell');
            $table->unsignedBigInteger('alternate_cell')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('emerg_name')->nullable();
            $table->string('emerg_phone1')->nullable();
            $table->string('emerg_phone2')->nullable();
            $table->unsignedInteger('emerg_relation_id')->nullable();
            $table->foreign('emerg_relation_id')->references('id')->on('relationships')->onDelete('restrict');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict');
            $table->unsignedInteger('staff_type_id');
            $table->foreign('staff_type_id')->references('id')->on('staff_types')->onDelete('restrict');
            $table->boolean('expires')->default(true);
            $table->date('expiry_date')->nullable()->index();
            $table->unsignedBigInteger('profession_id');
            $table->foreign('profession_id')->references('id')->on('professions')->onDelete('restrict');
            $table->unsignedBigInteger('staff_specialty_id')->nullable();
            $table->foreign('staff_specialty_id')->references('id')->on('staff_specialties')->onDelete('restrict');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('status',['ACTIVE','INACTIVE','SUSPENDED','LOCKED','RECOVERY_MODE','DISMISSED'])->default('ACTIVE');
            $table->date('appointment_date')->nullable();
            $table->string('ssnit_no')->unique()->nullable();
            $table->string('tin')->unique()->nullable();
            $table->decimal('basic',2)->default(0);
            $table->unsignedInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('restrict');
            $table->unsignedBigInteger('bank_branch_id')->nullable();
            $table->foreign('bank_branch_id')->references('id')->on('bank_branches')->onDelete('restrict');
            $table->string('bank_acct_no')->nullable();
            $table->unsignedInteger('staff_category_id')->nullable();
            $table->foreign('staff_category_id')->references('id')->on('staff_categories')->onDelete('restrict');
            $table->string('prof_body')->nullable();
            $table->string('prof_reg_no')->nullable()->unique();
            $table->date('prof_expiry_date')->nullable()->unique();
            $table->string('signature')->nullable();
            $table->string('picture')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_logout')->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
