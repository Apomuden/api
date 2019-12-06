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
            ['name'=>'Mr'],
            ['name'=>'Mrs'],
            ['name'=>'Ms'],
            ['name'=>'Miss'],
            ['name'=>'Master'],
            ['name'=>'Madam'],
            ['name'=>'Maid'],
        ]);
    }
}
