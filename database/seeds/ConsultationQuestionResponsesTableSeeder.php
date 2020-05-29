<?php

use App\Models\ConsultationQuestionResponse;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConsultationQuestionResponsesTableSeeder extends Seeder
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
        ConsultationQuestionResponse::query()->insert([
            [
                "id" => 1,
                "patient_id" => 27,
                "consultation_id" => 35,
                "consultation_question_id" => 5,
                "consultant_id" => "82d3cca5-938a-4c98-85da-25d852680ea4",
                "response" => "Food",
                "response_date" => Carbon::now(),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 2,
                "patient_id" => 27,
                "consultation_id" => 35,
                "consultation_question_id" => 1,
                "consultant_id" => "82d3cca5-938a-4c98-85da-25d852680ea4",
                "response" => "Alice",
                "response_date" => Carbon::now(),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
            [
                "id" => 3,
                "patient_id" => 27,
                "consultation_id" => 35,
                "consultation_question_id" => 4,
                "consultant_id" => "82d3cca5-938a-4c98-85da-25d852680ea4",
                "response" => "True",
                "response_date" => Carbon::now(),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now()
            ],
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
