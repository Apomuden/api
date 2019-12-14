<?php

use App\Models\SponsorshipType;
use Illuminate\Database\Seeder;

class sponsorshipTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SponsorshipType::insert([
            ['name'=>'Patient'],
            ['name'=>'Government Insurance'],
            ['name'=>'Government Company'],
            ['name'=>'Private Company'],
            ['name'=>'Private Insurance'],
        ]);
    }
}
