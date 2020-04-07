<?php

use App\Models\ServiceCategory;
use App\Models\HospitalService;
use Illuminate\Database\Seeder;

class ServiceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services_ids = [
            HospitalService::where('name','CONSULTATION')->first()->id,
            HospitalService::where('name','INVESTIGATION')->first()->id,
            HospitalService::where('name','SURGERY')->first()->id,
            HospitalService::where('name','MISCELLANEOUS')->first()->id
        ];
        ServiceCategory::insert([
            //Categories Under CONSULTATION
            ['name' => 'GENERAL', 'hospital_service_id' => $services_ids[0]],
            ['name' => 'ANTENATAL', 'hospital_service_id' => $services_ids[0]],
            ['name' => 'DENTAL', 'hospital_service_id' => $services_ids[0]],
            ['name' => 'ENT', 'hospital_service_id' => $services_ids[0]],
            ['name' => 'EYE', 'hospital_service_id' => $services_ids[0]],

            //CATEGORIES UNDER INVESTIGATION
            ['name' => 'LABORATORY', 'hospital_service_id' => $services_ids[1]],
            ['name' => 'RADIOLOGY', 'hospital_service_id' => $services_ids[1]],
            ['name' => 'ULTRASOUND', 'hospital_service_id' => $services_ids[1]],
            ['name' => 'MRI', 'hospital_service_id' => $services_ids[1]],
            ['name' => 'ECG', 'hospital_service_id' => $services_ids[1]],

            //Categories Under SURGERY
            ['name' => 'ADULT SURGERY', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'PAEDIATRIC SURGERY', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'OPHTHALMOLOGY', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'ORTHOPAEDICS', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'DENTAL', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'EAR NOSE AND THROAT', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'OBSTETRICS AND GYNAECOLOGY', 'hospital_service_id' => $services_ids[2]],
            ['name' => 'RECONSTRUCTIVE', 'hospital_service_id' => $services_ids[2]],

            //Categories under Miscellaneous
            ['name' => 'Hospital ID Card', 'hospital_service_id' => $services_ids[3]],
            ['name' => 'Ambulance', 'hospital_service_id' => $services_ids[3]],
            ['name' => 'Police Form', 'hospital_service_id' => $services_ids[3]]
        ]);
    }
}
