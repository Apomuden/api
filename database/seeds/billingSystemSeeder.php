<?php

use App\Models\BillingSystem;
use Illuminate\Database\Seeder;

class billingSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillingSystem::insert([
            ['name'=>ucwords('UNBUNDLED/ITEMIZE')],
            ['name'=>ucwords('GHANA RELATED DIAGNOSIS GROUPING (GDRG)')],
        ]);
    }
}
