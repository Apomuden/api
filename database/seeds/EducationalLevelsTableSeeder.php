<?php

use App\Models\EducationalLevel;
use Illuminate\Database\Seeder;

class EducationalLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationalLevel::insert([
            ['name'=>'Primary Education'],
            ['name'=>'Secondary Education'],
            ['name'=>'Pre-Tertiary Education'],
            ['name'=>'Undergraduate Degree'],
            ['name'=>'Associate Degree'],
            ['name'=>'Bachelor Degrees'],
            ['name'=>"Master's Degree"],
            ['name'=>"Doctoral Degree"],
            ['name'=>"Professional Degree"],
        ]);
    }
}
