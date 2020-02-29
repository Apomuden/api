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
            ['id'=>1, 'name'=>'Temperature', 'unit'=>'℃', 'min_value'=>36.0, 'max_value'=>37.3, 'reference_name'=>'temperature'],
            ['id'=>2, 'name'=>'Pulse', 'unit'=>'bpm', 'min_value'=>60, 'max_value'=>100, 'reference_name'=>'pulse'],
            ['id'=>3, 'name'=>'Blood Pressure (Systolic)', 'unit'=>'mmHg', 'min_value'=>90, 'max_value'=>120, 'reference_name'=>'systolic_blood_pressure'],
            ['id'=>4, 'name'=>'Blood Pressure (Diastolic)', 'unit'=>'mmHg', 'min_value'=>60, 'max_value'=>80, 'reference_name'=>'diastolic_blood_pressure'],
            ['id'=>5, 'name'=>'Respiration', 'unit'=>'cpm', 'min_value'=>12, 'max_value'=>24, 'reference_name'=>'respiration'],
            ['id'=>6, 'name'=>'Weight', 'unit'=>'kg', 'min_value'=>null, 'max_value'=>null, 'reference_name'=>'weight'],
            ['id'=>7, 'name'=>'Height', 'unit'=>'cm', 'min_value'=>null, 'max_value'=>null, 'reference_name'=>'height'],
            ['id'=>8, 'name'=>'Body Mass Index (BMI)', 'unit'=>'Kg/m²', 'min_value'=>18.5, 'max_value'=>24.9, 'reference_name'=>'bmi'],
            ['id'=>9, 'name'=>'Oxygen Saturation (SPO₂)', 'unit'=>'%', 'min_value'=>95, 'max_value'=>100, 'reference_name'=>'oxygen_saturation'],
            ['id'=>10, 'name'=>'Fasting Blood Sugar (FBS)', 'unit'=>'mmol/l', 'min_value'=>3.3, 'max_value'=>6.1, 'reference_name'=>'fasting_blood_sugar'],
            ['id'=>11, 'name'=>'Random Blood Sugar (RBS)', 'unit'=>'mmol/l', 'min_value'=>6.2, 'max_value'=>10.1, 'reference_name'=>'random_blood_sugar'],
        ]);
        Measurement::reguard();
        Schema::enableForeignKeyConstraints();
    }
}
