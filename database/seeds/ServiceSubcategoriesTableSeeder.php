<?php
use App\Models\ServiceSubcategory;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceSubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service_category_ids = [
            ServiceCategory::where('name','LABORATORY')->first(),
            ServiceCategory::where('name','ADULT SURGERY')->first(),
            ServiceCategory::where('name','PAEDIATRIC SURGERY')->first(),
        ];

        ServiceSubcategory::insert([
            //Subcategory under Laboratory
            ['name' => 'HAEMATOLOGY', 'service_category_id' => $service_category_ids[0]->id, 'hospital_service_id' => $service_category_ids[0]->hospital_service_id],
            ['name' => 'BIOCHEMISTRY', 'service_category_id' => $service_category_ids[0]->id, 'hospital_service_id' => $service_category_ids[0]->hospital_service_id],
            ['name' => 'UROLOGY', 'service_category_id' => $service_category_ids[0]->id, 'hospital_service_id' => $service_category_ids[0]->hospital_service_id],
            ['name' => 'SEROLOGY', 'service_category_id' => $service_category_ids[0]->id, 'hospital_service_id' => $service_category_ids[0]->hospital_service_id],
            ['name' => 'MICROBIOLOGY', 'service_category_id' => $service_category_ids[0]->id, 'hospital_service_id' => $service_category_ids[0]->hospital_service_id],

            //Subcategory under adult surgery
            ['name' => 'MAJOR', 'service_category_id' => $service_category_ids[1]->id, 'hospital_service_id' => $service_category_ids[1]->hospital_service_id],
            ['name' => 'MINOR', 'service_category_id' => $service_category_ids[1]->id, 'hospital_service_id' => $service_category_ids[1]->hospital_service_id],

            //Subcategory under paediatric surgery
            ['name' => 'MAJOR', 'service_category_id' => $service_category_ids[2]->id, 'hospital_service_id' => $service_category_ids[2]->hospital_service_id],
            ['name' => 'MINOR', 'service_category_id' => $service_category_ids[2]->id, 'hospital_service_id' => $service_category_ids[2]->hospital_service_id]
        ]);
    }
}
