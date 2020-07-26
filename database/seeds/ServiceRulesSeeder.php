<?php

use App\Models\ServiceRule;
use Illuminate\Database\Seeder;

class ServiceRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRule::insert([
            ['name'=> 'Enforce Consultation Payment Before Vitals'],
            ['name'=> 'Submit Patient Vital Signs Before Consultation'],
        ]);
    }
}
