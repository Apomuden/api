<?php

use App\Models\StaffCategory;
use Illuminate\Database\Seeder;

class StaffCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffCategory::insert([
            ['name'=>'Nurse'],
            ['name'=>'Physician'],
            ['name'=>'Pharmacist'],
        ]);
    }
}
