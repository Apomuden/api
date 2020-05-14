<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed patient
 * @property mixed id
 * @property mixed consultation_id
 * @property mixed consultation_question_id
 * @property mixed consultant_id
 * @property mixed response_date
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed consultant
 * @property mixed consultation_question
 * @property mixed response
 * @property mixed consultation
 */
class ConsultationQuestionResponseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'folder_no' => $this->patient->activefolder->folder_no . $this->patient->postfix,
            'patient_title' => $this->patient->title->name,
            'patient_name' => $this->patient->fullname,
            'age' => $this->consultation->age,

            'patient_status' => $this->consultation->patient_status,
            'consultation_id' => $this->consultation_id,
            'consultation_question_id' => $this->consultation_question_id,
            'consultation_question' => $this->consultation_question->question,
            'value_type' => $this->consultation_question->value_type,
            'response' => $this->response,
            'consultant_id' => $this->consultant_id,
            'consultant_name' => $this->consultant->fullname ?? null,
            'response_date' => $this->response_date ? DateHelper::toDisplayDateTime($this->response_date) : null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
