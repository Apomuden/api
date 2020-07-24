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
            array('id' => '1', 'name' => 'CASH', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => NULL, 'updated_at' => '2020-07-21 00:22:53', 'deleted_at' => NULL),
            array('id' => '2', 'name' => 'MTN Mobile Money', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => '2020-07-23 00:00:00', 'updated_at' => '2020-07-21 00:23:16', 'deleted_at' => NULL),
            array('id' => '3', 'name' => 'Cheque', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => NULL, 'updated_at' => '2020-07-21 00:23:07', 'deleted_at' => NULL),
            array('id' => '4', 'name' => 'ESWITCH', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => NULL, 'updated_at' => NULL, 'deleted_at' => NULL),
            array('id' => '5', 'name' => 'POS', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => NULL, 'updated_at' => NULL, 'deleted_at' => NULL),
            array('id' => '6', 'name' => 'Bank Interface', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => '2019-12-20 13:19:54', 'updated_at' => '2019-12-20 13:19:54', 'deleted_at' => NULL),
            array('id' => '8', 'name' => 'Bank Deposit', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => '2019-12-20 13:19:54', 'updated_at' => '2019-12-20 13:19:54', 'deleted_at' => NULL),
            array('id' => '9', 'name' => 'AirtelTigo Money', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => '2020-07-23 00:00:00', 'updated_at' => '2020-07-21 00:23:16', 'deleted_at' => NULL),
            array('id' => '10', 'name' => 'Vodafone Cash', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => '2020-07-23 00:00:00', 'updated_at' => '2020-07-21 00:23:16', 'deleted_at' => NULL),
            array('id' => '11', 'name' => 'G-Money', 'priority' => NULL, 'status' => 'ACTIVE', 'created_at' => '2020-07-23 00:00:00', 'updated_at' => '2020-07-21 00:23:16', 'deleted_at' => NULL)
        ]);
    }
}
