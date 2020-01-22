<?php

use App\Models\BillingCycle;
use App\Models\Clinic;
use App\Models\ClinicConsultService;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicConsultServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $clinics = Clinic::all();
        DB::beginTransaction();
        foreach ($clinics as $clinic) {
            ClinicConsultService::insert([
                ['clinic_id' => $clinic->id, 'billing_cycle_id' => BillingCycle::all()->random()->id ?? null, 'service_category_id' => ServiceCategory::all()->random()->id ?? null, 'duration' => random_int(1, 9), 'price' => random_int(1, 9)],
            ]);
        }
        DB::commit();
    }
}
