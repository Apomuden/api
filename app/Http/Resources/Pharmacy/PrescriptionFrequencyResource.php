<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionFrequencyResource extends JsonResource
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
                'id' => $this->id,
                'name' => $this->name,
                'value' => $this->value,
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }

        return null;
    }
}
