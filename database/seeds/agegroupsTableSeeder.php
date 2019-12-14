<?php

use App\Models\AgeGroup;
use Illuminate\Database\Seeder;

class agegroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      AgeGroup::insert([
          ['name'=>'Infant','duration_type'=>'MONTH','min_age'=>0,'max_age'=>3],
          ['name'=>'Baby','duration_type'=>'YEAR','min_age'=>0,'max_age'=>2],
          ['name'=>'Child','duration_type'=>'YEAR','min_age'=>3,'max_age'=>17],
          ['name'=>'Adult','duration_type'=>'YEAR','min_age'=>18,'max_age'=>30],
          ['name'=>'Middle-Aged Adult','duration_type'=>'YEAR','min_age'=>31,'max_age'=>45],
          ['name'=>'Old Adult','duration_type'=>'YEAR','min_age'=>46,'max_age'=>null],
      ]);
    }
}
