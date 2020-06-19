<?php

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    Schema::disableForeignKeyConstraints();
    DB::statement('truncate table modules');
    $modules = array(
        array('id' => '1','name' => 'User Management','tag' => 'users-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '2','name' => 'Records Management','tag' => 'records-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '3','name' => 'Nursing Management','tag' => 'nursing-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '4','name' => 'Outpatient Management','tag' => 'opd-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '5','name' => 'Inpatient Management','tag' => 'ipd-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '6','name' => 'Physician Management','tag' => 'physician-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '7','name' => 'Laboratory Management','tag' => 'lab-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '8','name' => 'Radiology Management','tag' => 'radio-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '9','name' => 'Pharmacy Management','tag' => 'pharm-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '10','name' => 'Accounts Management','tag' => 'acct-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '11','name' => 'Inventory Management','tag' => 'invent-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '12','name' => 'Theater Management','tag' => 'theater-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '13','name' => 'Birth and Death Management','tag' => 'motality-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '14','name' => 'Procurement Management','tag' => 'procure-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '15','name' => 'EInsurance and Corporate Policy Management','tag' => 'insure-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '16','name' => 'Reports Management','tag' => 'reports-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '17','name' => 'System Configurations','tag' => 'sys-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '18','name' => 'Dashboard','tag' => 'dashboard','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00'),
        array('id' => '19','name' => 'Obstetrics Management','tag' => 'obs-mgt','status' => 'ACTIVE','created_at' => '2020-01-07 00:00:00','updated_at' => '2020-01-07 00:00:00')
      );

      Module::insert($modules);
      Schema::enableForeignKeyConstraints();

   }
}
