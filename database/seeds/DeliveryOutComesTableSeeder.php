<?php

use App\Models\Obstetrics\DeliveryOutcome;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeliveryOutComesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::statement('truncate table delivery_outcomes');
        DeliveryOutcome::query()->insert([
            [
                "id" => 1,
                "name" => "Live Birth",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "name" => "Still Birth",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "name" => "Miscarriage",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
