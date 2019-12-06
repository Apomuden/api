<?php

use App\Models\StaffType;
use Illuminate\Database\Seeder;

class StaffTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffType::insert([
            ['name'=>'National service'],
            ['name'=>'Permanent'],
            ['name'=>'Nabco'],
            ['name'=>'Voluntary'],
            ['name'=>'Other']
        ]);
    }
}
