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
        DB::statement('truncate table product_types');
        ProductType::query()->insert([
            [
                "id"=>1,
                "name"=>"DRUG",
                "status"=>"ACTIVE",
                "created_at"=> Carbon::now(),
                "updated_at"=> Carbon::now()
            ],
            [
                "id"=>2,
                "name"=>"NON-DRUG",
                "status"=>"ACTIVE",
                "created_at"=> Carbon::now(),
                "updated_at"=> Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
