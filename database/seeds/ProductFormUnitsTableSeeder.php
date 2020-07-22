<?php

use App\Models\ProductFormUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductFormUnitsTableSeeder extends Seeder
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
            ['name'=>'Bottle','unit_type'=>'VOLUME'],
            ['name'=>'Strip','unit_type'=>'BASE'],
            ['name'=>'Pack','unit_type'=>'BASE']
        ];
        foreach ($records as $record) {
            $record = array_merge($record, [
                "status"=>"ACTIVE",
                "created_at"=> "2020-07-17 4:27:00",
                "updated_at"=> "2020-07-17 4:27:00"
            ]);
            //dd($record);
            ProductFormUnit::query()->firstOrCreate($record);
        }

        Schema::enableForeignKeyConstraints();
    }
}
