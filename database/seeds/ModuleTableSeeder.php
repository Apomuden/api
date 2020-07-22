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
        ['id'=>1,'name'=>'Dashboard', 'parent_tag'=>null,'tag'=>'dashboard','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>2,'name'=>'Facility Management', 'parent_tag' => null,'tag'=>'facility','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>3,'name'=>'Funding Settings', 'parent_tag' => 'facility','tag'=>'facility.funding','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>4,'name'=>'Consultation Settings', 'parent_tag' => 'facility','tag'=>'facility.consultation','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>5,'name'=>'System Configurations', 'parent_tag' => null,'tag'=>'config','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>6,'name'=>'Records Setup','parent_tag'=> 'config','tag'=>'config.record','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>7,'name'=>'Accounts Setup', 'parent_tag' => 'config','tag'=>'config.account','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>8,'name'=>'InPatient Setup', 'parent_tag' => 'config','tag'=>'config.inpatient','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>9,'name'=>'Laboratory Setup', 'parent_tag' => 'config','tag'=>'config.lab','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>10,'name'=>'Stores Setup', 'parent_tag' => 'config','tag'=>'config.store','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>11,'name'=>'EINSU. & CORP.', 'parent_tag' => 'config','tag'=>'config.einsu','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>12,'name'=>'Other', 'parent_tag' => 'config','tag'=>'config.other','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>13,'name'=>'Clinicals Setup', 'parent_tag' => 'config','tag'=>'config.clinic','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>14,'name'=>'Obstetric Setting', 'parent_tag' => 'config','tag'=>'config.obstetric','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>15,'name'=>'User Management', 'parent_tag' => null,'tag'=>'security','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>16,'name'=>'Records Management', 'parent_tag' => null,'tag'=>'record','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>17,'name'=>'OPD Management', 'parent_tag' => null,'tag'=>'opd','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>18,'name'=>'Clinical Management', 'parent_tag' => null,'tag'=>'clinical','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>19,'name'=>'Obstetric Management', 'parent_tag' => null,'tag'=> 'obstetric','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>20,'name'=>'Laboratory Management', 'parent_tag' => null,'tag'=>'lab','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>21,'name'=>'Account Management', 'parent_tag' => null,'tag'=>'account','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>22,'name'=>'Stores Management', 'parent_tag' => null,'tag'=>'store','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
        ['id'=>23,'name'=>'Pharmacy Management', 'parent_tag' => null,'tag'=>'pharmacy','status'=>'ACTIVE','created_at'=>now(),'updated_at'=>now()],
      );

      Module::insert($modules);
      Schema::enableForeignKeyConstraints();

   }
}
