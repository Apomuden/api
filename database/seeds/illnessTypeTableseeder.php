<?php

use App\Models\IllnessType;
use Illuminate\Database\Seeder;

class illnessTypeTableseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IllnessType::create([
            'name'=>'ACUTE'
        ]);
        IllnessType::create([
            'name'=> 'CHRONIC'
        ]);
        IllnessType::create([
            'name'=> 'EMERGENCY'
        ]);
    }
}
