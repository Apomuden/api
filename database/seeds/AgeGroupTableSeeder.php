<?php

use App\Models\AgeGroup;
use Illuminate\Database\Seeder;

class AgeGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AgeGroup::insert([
            ['name'=>'Infant','max_age_unit'=>'MONTH', 'min_age_unit'=>'MONTH','min_age'=>3,'max_age'=>12],
            ['name'=>'Baby','max_age_unit'=>'YEAR', 'min_age_unit'=>'MONTH','min_age'=>0,'max_age'=>2],
            ['name'=>'Child','max_age_unit'=>'YEAR', 'min_age_unit'=>'YEAR','min_age'=>3,'max_age'=>17],
            ['name'=>'Adult','max_age_unit'=>'YEAR', 'min_age_unit'=>'YEAR','min_age'=>18,'max_age'=>30],
            ['name'=>'Middle-Aged Adult','max_age_unit'=>'YEAR', 'min_age_unit'=>'YEAR','min_age'=>31,'max_age'=>45],
            ['name'=>'Old Adult','max_age_unit'=>'YEAR', 'min_age_unit'=>'YEAR','min_age'=>46,'max_age'=>null],
        ]);
    }
}
