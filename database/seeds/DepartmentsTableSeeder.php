<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            ['name'=>'Anaesthetics'],
            ['name'=>'Breast screening'],
            ['name'=>'Cardiology'],
            ['name'=>'Critical care'],
            ['name'=>'Diagnostic imaging'],
        ]);
    }
}
