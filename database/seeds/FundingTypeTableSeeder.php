<?php

use App\Models\FundingType;
use Illuminate\Database\Seeder;

class FundingTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FundingType::insert([
            ['name'=>'Cash'],
            ['name'=>'NHIS'],
            ['name'=>'Private Insurance'],
            ['name'=>'Corporate'],
            ['name'=>'Private Individual'],
        ]);
    }
}
