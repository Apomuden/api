<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ObstetricQuestionOptionResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            return [
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'id' => $this->id,
            'obstetric_question_id' => $this->obstetric_question_id,
            'status' => $this->status,
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            'value' => $this->value,

            ];
        }

        return null;
    }
}
