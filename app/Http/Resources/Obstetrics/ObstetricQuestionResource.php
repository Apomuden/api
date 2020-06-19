<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ObstetricQuestionResource extends JsonResource
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
'order' => $this->order,
'question' => $this->question,
'status' => $this->status,
'step' => $this->step,
'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
'value_type' => $this->value_type,

            ];
        }

        return NULL;
    }
}
