<?php

use App\Models\Religion;
use Illuminate\Database\Seeder;

class ReligionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Religion::insert([
            ['name'=>'Christianity'],
            ['name'=>'Islam'],
            ['name'=>'Hinduism'],
            ['name'=>'Buddhism'],
            ['name'=>'African traditional and Diasporic'],
            ['name'=>'Judaism'],
        ]);
    }
}
