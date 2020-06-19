<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed patient
 * @property mixed id
 * @property mixed consultation_id
 * @property mixed consultant_id
 * @property mixed consultation_date
 * @property mixed responses
 * @property mixed attendance_date
 * @property mixed obstetric_question_responses
 */
class ObsConsultationGroupedQuestionResponseResource extends JsonResource
{
    public function toArray($request)
    {
        $responses = ObstetricQuestionResponseResource::collection($this->obstetric_question_responses);
        return [
            'consultation_id' => $this->id,
            'consultation_date' => DateHelper::toDisplayDateTime($this->attendance_date),
            'responses' => $responses
        ];
    }
}
