<?php

use App\Models\HospitalService;
use Illuminate\Database\Seeder;

class HospitalServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HospitalService::insert([
            ['name' => 'CONSULTATION'],
            ['name' => 'INVESTIGATION'],
            ['name' => 'SURGERY'],
            ['name' => 'MISCELLANEOUS']
        ]);
    }
}
