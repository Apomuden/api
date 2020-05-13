<?php

use App\Models\ConsultationQuestion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConsultationQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::statement('truncate table consultation_questions');
        ConsultationQuestion::query()->insert([
            [
                "id" => 1,
                "question" => "What is your wife's name?",
                "gender" => "MALE",
                "value_type" => "Text",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "question" => "What is your husband's name?",
                "gender" => "FEMALE",
                "value_type" => "Text",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "question" => "How many children do you have?",
                "gender" => "MALE,FEMALE",
                "value_type" => "Number",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 4,
                "question" => "Are you ok?",
                "gender" => "MALE,FEMALE",
                "value_type" => "True/False",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 5,
                "question" => "What do you like?",
                "gender" => "MALE,FEMALE",
                "value_type" => "Select",
                "status" => "ACTIVE",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
