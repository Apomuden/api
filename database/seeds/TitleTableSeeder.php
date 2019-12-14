<?php

use Illuminate\Database\Seeder;
use App\Models\Title;

class TitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Title::insert([
            ['name'=>'Mr','gender'=>'MALE'],
            ['name'=>'Mrs','gender'=>'FEMALE'],
            ['name'=>'Ms','gender'=>'FEMALE'],
            ['name'=>'Miss','gender'=>'FEMALE'],
            ['name'=>'Master','gender'=>'MALE'],
            ['name'=>'Madam','gender'=>'FEMALE'],
            ['name'=>'Maid','gender'=>'FEMALE'],
        ]);
    }
}
