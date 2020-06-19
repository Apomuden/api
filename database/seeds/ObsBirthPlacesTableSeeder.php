<?php

use App\Models\Obstetrics\ObsBirthPlace;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ObsBirthPlacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::statement('truncate table obs_birth_places');
        ObsBirthPlace::query()->insert([
            [
                "id" => 1,
                "name" => "Hospital",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "name" => "Health centre",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "name" => "CHPS",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 4,
                "name" => "Home",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 5,
                "name" => "Maternity Home",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 6,
                "name" => "Other",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
