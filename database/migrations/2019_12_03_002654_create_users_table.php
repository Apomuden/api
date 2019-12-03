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
            $table->unsignedInteger('user_title_id');
            $table->foreign('user_title_id')->references('id')->on('user_titles')->onDelete('restrict');
            $table->string('surname');
            $table->string('middlename')->nullable();
            $table->string('firstname');
            $table->date('dob');
            $table->enum('gender',['MALE','FEMALE']);
            $table->unsignedInteger('religion_id');
            $table->foreign('religion_id')->references('id')->on('religions')->onDelete('restrict');
            $table->string('profession');
            $table->unsignedInteger('educational_level_id');
            $table->foreign('educational_level_id')->references('id')->on('educational_levels')->onDelete('restrict');
            $table->mediumText('residence');
            $table->enum('marital',['SINGLE','MARRIED','DIVORCED','WIDOW','WIDOWER','OTHER']);
            $table->unsignedInteger('active_cell');
            $table->unsignedInteger('alternate_cell');
            $table->unsignedInteger('email');
            $table->string('emerg_fullname');
            $table->string('emerg_phone1');
            $table->string('emerg_phone2')->nullable();
            $table->unsignedInteger('emerg_relation_id');
            $table->foreign('emerg_relation_id')->references('id')->on('relationships')->onDelete('restrict');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict');
            $table->unsignedInteger('employment_type_id');
            $table->foreign('employment_type_id')->references('id')->on('employment_types')->onDelete('restrict');
            $table->boolean('expires')->default(true);
            $table->date('expiry_date')->nullable()->index();
            $table->unsignedBigInteger('profession_id');
            $table->foreign('profession_id')->references('id')->on('professions')->onDelete('restrict');
            $table->string('user_name')->nullable()->unique();
            $table->string('passsword');
            $table->enum('status',['ACTIVE','INACTIVE','SUSPENDED','LOCKED','RECOVERY_MODE','DISMISSED'])->default('ACTIVE');
            $table->date('appointment_date')->nullable();
            $table->string('ssnit_no')->unique()->nullable();
            $table->string('tin')->unique()->nullable();
            $table->unsignedInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('restrict');
            $table->unsignedBigInteger('bank_branch_id')->nullable();
            $table->foreign('bank_branch_id')->references('id')->on('bank_branches')->onDelete('restrict');
            $table->string('bank_acct_no');
            $table->unsignedInteger('staff_category_id')->nullable();
            $table->foreign('staff_category_id')->references('id')->on('staff_categories')->onDelete('restrict');
            $table->string('prof_body')->nullable();
            $table->string('prof_reg_no')->nullable()->unique();
            $table->date('prof_expiry_date')->nullable()->unique();
            $table->string('signature')->nullable();
            $table->string('picture')->nullable();
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
        Schema::dropIfExists('users');
    }
}
