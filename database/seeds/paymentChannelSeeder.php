<?php

use App\Models\PaymentChannel;
use Illuminate\Database\Seeder;

class paymentChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentChannel::insert([
            ['name'=>'Cash'],
            ['name'=>'Momo'],
            ['name'=>'Cheque'],
            ['name'=>'ESWITCH'],
            ['name'=>'POS'],
        ]);
    }
}
