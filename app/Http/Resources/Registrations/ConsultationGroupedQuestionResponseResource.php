<?php

namespace App\Http\Resources\Registrations;

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
 */
class ConsultationGroupedQuestionResponseResource extends JsonResource
{
    public function toArray($request)
    {
        $responses = ConsultationQuestionResponseResource::collection($this->responses);
        $consultant = 'Unknown';
        if (count($responses) > 0) {
            $consultant = $responses->resource[0]->toArray($responses->resource[0])['consultant_name'];
        }
        return [
            'consultation_id' => $this->id,
            'consultation_date' => DateHelper::toDisplayDateTime($this->attendance_date),
            'consultant_name' => $consultant,
            'responses' => $responses
        ];
    }
}
