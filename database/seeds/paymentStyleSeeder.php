<?php

use App\Models\PaymentStyle;
use Illuminate\Database\Seeder;

class paymentStyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentStyle::insert([
            ['name'=>'Prepaid'],
            ['name'=>'Postpaid'],
        ]);
    }
}
