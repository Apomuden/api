<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed consultant_id
 * @property mixed consultation_id
 * @property mixed created_at
 * @property mixed obstetric_question_id
 * @property mixed response_date
 * @property mixed updated_at
 * @property mixed patient_id
 * @property mixed response
 * @property mixed obstetric_question
 */
class ObstetricQuestionResponseResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            return [
                'id' => $this->id,
                'patient_id' => $this->patient_id,
                'consultation_id' => $this->consultation_id,
                'consultant_id' => $this->consultant_id,
                'obstetric_question' => $this->obstetric_question,
                'response' => $this->response,
                'response_date' => DateHelper::toDisplayDateTime($this->response_date),
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }

        return NULL;
    }
}
