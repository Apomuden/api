<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed consultation_question_id
 * @property mixed consultation_question
 * @property mixed created_at
 * @property mixed value
 * @property mixed updated_at
 * @property mixed status
 * @property mixed gender
 */
class ConsultationQuestionOptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'consultation_question_id' => $this->consultation_question_id,
            'consultation_question' => $this->consultation_question->question,
            'value' => $this->value,
            'gender' => $this->gender,
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
