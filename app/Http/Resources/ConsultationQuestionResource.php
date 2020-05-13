<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed question
 * @property mixed id
 * @property mixed created_at
 * @property mixed value_type
 * @property mixed gender
 * @property mixed updated_at
 * @property mixed status
 * @property mixed unit
 */
class ConsultationQuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'gender' => $this->gender,
            'value_type' => $this->value_type,
            'unit' => $this->unit,
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
