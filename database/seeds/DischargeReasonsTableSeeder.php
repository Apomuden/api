<?php

use App\Models\DischargeReason;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DischargeReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DischargeReason::insert([
            ['name'=> 'DISCHARGE SUCCESSFULLY','created_at'=>Carbon::now()],
            ['name'=> 'DISCHARGE AGAINST MEDICAL ADVICE','created_at'=>Carbon::now()],
            ['name'=> 'REFERRAL','created_at'=>Carbon::now()],
            ['name'=> 'RECOMMENDED FOR ADMISSION','created_at'=>Carbon::now()]
        ]);
    }
}
