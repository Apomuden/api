<?php

use App\Models\Profession;
use App\Models\StaffCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProfessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc_assist_id=StaffCategory::where('name','Physician')->first()->id;
        $nurse_id=StaffCategory::where('name','Nurse')->first()->id;
        $pharmacist_id=StaffCategory::where('name','Pharmacist')->first()->id;

        Profession::insert([
            [
                'name'=>'Cardiologist',
                'staff_category_id'=>$doc_assist_id
            ],
            [
                'name'=>'Dermatologist',
                'staff_category_id'=>$doc_assist_id
            ],
            [
                'name'=>'Anesthesiologist',
                'staff_category_id'=>$nurse_id
            ],
            [
                'name'=>'Midwife',
                'staff_category_id'=>$nurse_id
            ],
            [
                'name'=>'Chemotherapist',
                'staff_category_id'=>$pharmacist_id
            ],
            [
                'name'=>'Clinical Pharmacist',
                'staff_category_id'=>$pharmacist_id
            ],
        ]);
    }
}
