<?php

use App\Models\BillingCycle;
use Illuminate\Database\Seeder;

class billingCycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillingCycle::insert([
            ['name'=>'Daily'],
            ['name'=>'Weekly'],
            ['name'=>'Monthly'],
            ['name'=>'Quarterly'],
            ['name'=>'Yearly'],
            ['name'=>'Flat Amount'],
            ['name'=>'Hourly'],
            ['name'=>'Minutely'],
        ]);
    }
}
