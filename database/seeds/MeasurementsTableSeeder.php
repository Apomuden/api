<?php

use App\Models\Measurement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MeasurementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Measurement::truncate();
        Measurement::unguard();
        Measurement::insert([
            ['id'=>1, 'name'=>'Temperature', 'unit'=>'℃', 'min_value'=>36.0, 'max_value'=>37.3],
            ['id'=>2, 'name'=>'Pulse', 'unit'=>'bpm', 'min_value'=>60, 'max_value'=>100],
            ['id'=>3, 'name'=>'Blood Pressure (Systolic)', 'unit'=>'mmHg', 'min_value'=>90, 'max_value'=>120],
            ['id'=>4, 'name'=>'Blood Pressure (Diastolic)', 'unit'=>'mmHg', 'min_value'=>60, 'max_value'=>80],
            ['id'=>5, 'name'=>'Respiration', 'unit'=>'cpm', 'min_value'=>12, 'max_value'=>24],
            ['id'=>6, 'name'=>'Weight', 'unit'=>'kg', 'min_value'=>null, 'max_value'=>null],
            ['id'=>7, 'name'=>'Height', 'unit'=>'cm', 'min_value'=>null, 'max_value'=>null],
            ['id'=>8, 'name'=>'Body Mass Index (BMI)', 'unit'=>'Kg/m²', 'min_value'=>18.5, 'max_value'=>24.9],
            ['id'=>9, 'name'=>'SPO₂', 'unit'=>'%', 'min_value'=>95, 'max_value'=>100],
            ['id'=>10, 'name'=>'Fasting Blood Sugar (FBS)', 'unit'=>'mmol/l', 'min_value'=>3.3, 'max_value'=>6.1],
            ['id'=>11, 'name'=>'Random Blood Sugar (RBS)', 'unit'=>'mmol/l', 'min_value'=>6.2, 'max_value'=>10.1],
        ]);
        Measurement::reguard();
        Schema::enableForeignKeyConstraints();
    }
}
