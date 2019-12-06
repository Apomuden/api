<?php

use App\Models\FundingType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

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
