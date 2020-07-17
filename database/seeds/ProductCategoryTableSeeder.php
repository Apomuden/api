<?php

use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $records = [
            ['name'=>'Antipyretics','product_type_id'=>1],
            ['name'=>'Antimalarial','product_type_id'=>1],
            ['name'=>'Antiseptics','product_type_id'=>1],
            ['name'=>'Mood stabilizers','product_type_id'=>1],
            ['name'=>'Hormone replacements','product_type_id'=>1],
            ['name'=>'Oral contraceptives','product_type_id'=>1],
            ['name'=>'Stimulants','product_type_id'=>1],
            ['name'=>'Tranquilizers','product_type_id'=>1],
            ['name'=>'Statins','product_type_id'=>1]
        ];
        foreach ($records as $record) {
            $record = array_merge($record, [
                "status"=>"ACTIVE",
                "created_at"=> "2020-07-17 4:27:00",
                "updated_at"=> "2020-07-17 4:27:00"
            ]);
            //dd($record);
            ProductCategory::query()->firstOrCreate($record);
        }

        Schema::enableForeignKeyConstraints();
    }
}
