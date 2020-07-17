<?php

use App\Models\MedicineRoute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MedicineRouteTableSeeder extends Seeder
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
            ['name'=>'Oral'],
            ['name'=>'Parenteral'],
            ['name'=>'Mouth Inhalation'],
            ['name'=>'Nasal Inhalation'],
            ['name'=>'Intranasal'],
            ['name'=>'Sublingual'],
            ['name'=>'Buccal'],
            ['name'=>'Sublabial']
        ];
        foreach ($records as $record) {
            $record = array_merge($record, [
                "status"=>"ACTIVE",
                "created_at"=> "2020-07-17 4:27:00",
                "updated_at"=> "2020-07-17 4:27:00"
            ]);
            //dd($record);
            MedicineRoute::query()->firstOrCreate($record);
        }

        Schema::enableForeignKeyConstraints();
    }
}
