<?php

use App\Models\ConsultationComponent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConsultationComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::statement('truncate table consultation_components');
        ConsultationComponent::query()->insert([
            [
                "id" => 1,
                "name" => "Physical Examination",
                "status" => "Active",
                "created_at" => now()
            ],
            [
                "id" => 2,
                "name" => "Questionnaire",
                "status" => "Active",
                "created_at" => now()
            ],
            [
                "id" => 3,
                "name" => "Patient History",
                "status" => "Active",
                "created_at" => now()
            ],
            [
                "id" => 4,
                "name" => "Clinical Notes",
                "status" => "Active",
                "created_at" => now()
            ],
            [
                "id" => 5,
                "name" => "Prescription",
                "status" => "Active",
                "created_at" => now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
