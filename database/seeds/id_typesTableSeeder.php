<?php

use App\Models\IdType;
use Illuminate\Database\Seeder;

class id_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IdType::insert([
            ['name'=>'National ID','expires'=>true],
            ['name'=>'Voter ID','expires'=>false],
            ['name'=>'Health Insurance ID','expires'=>true],
        ]);
    }
}
