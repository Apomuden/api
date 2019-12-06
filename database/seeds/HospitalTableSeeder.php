<?php

use App\Models\Hospital;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class HospitalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Hospital::class,1)->create();
    }
}
