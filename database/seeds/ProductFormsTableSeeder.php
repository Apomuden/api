<?php

use App\Models\ProductForm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductFormsTableSeeder extends Seeder
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
            ['name'=>'Syrup', 'product_type_id'=>1],
            ['name'=>'Tablet', 'product_type_id'=>1],
            ['name'=>'Capsule', 'product_type_id'=>1],
            ['name'=>'Drop', 'product_type_id'=>1],
            ['name'=>'Inhaler', 'product_type_id'=>1],
            ['name'=>'Injection', 'product_type_id'=>1],
            ['name'=>'Implant', 'product_type_id'=>1],
            ['name'=>'Cream/Lotion', 'product_type_id'=>1],
            ['name'=>'Ointment', 'product_type_id'=>1]
        ];
        foreach ($records as $record) {
            $record = array_merge($record, [
                "status"=>"ACTIVE",
                "created_at"=> "2020-07-17 4:27:00",
                "updated_at"=> "2020-07-17 4:27:00"
            ]);
            //dd($record);
            ProductForm::query()->firstOrCreate($record);
        }

        Schema::enableForeignKeyConstraints();
    }
}
