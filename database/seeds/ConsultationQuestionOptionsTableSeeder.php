<?php

use App\Models\ConsultationQuestionOption;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConsultationQuestionOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::statement('truncate table consultation_question_options');
        ConsultationQuestionOption::query()->insert([
            [
                "id" => 1,
                "consultation_question_id" => 5,
                "value" => "Food",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "consultation_question_id" => 5,
                "value" => "Singing",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
