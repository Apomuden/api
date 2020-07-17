<?php

use App\Models\ProductType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        //DB::statement('truncate table product_types');
        $records = [
            [
                "name"=>"DRUG",
                "status"=>"ACTIVE",
                "created_at"=> "2020-07-17 4:27:00",
                "updated_at"=> "2020-07-17 4:27:00",
            ],
            [
                "name"=>"NON-DRUG",
                "status"=>"ACTIVE",
                "created_at"=> "2020-07-17 4:27:00",
                "updated_at"=> "2020-07-17 4:27:00",
            ]
        ];

        foreach ($records as $record) {
            ProductType::query()->firstOrCreate($record);
        }
        Schema::enableForeignKeyConstraints();
    }
}
