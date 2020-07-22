<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
                'unit' => $this->unit,
                'min_value' => ($this->min_value !== null) ? rtrim(rtrim($this->min_value, 0), '.') : null,
                'max_value' => ($this->max_value !== null) ? rtrim(rtrim($this->max_value, 0), '.') : null,
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        return null;
    }
}
