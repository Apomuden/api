<?php

namespace App\Http\Resources\Lab;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class LabParameterRangeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'lab_parameter_id'=>$this->lab_parameter_id,
            'lab_parameter_name'=>$this->lab_parameter->name,
            'lab_parameter_description'=>$this->lab_parameter->description,
            'flag'=>$this->flag,
            'min_comparator'=>$this->min_comparator,
            'min_value'=>$this->min_value,
            'max_comparator'=>$this->max_comparator,
            'max_value'=>$this->max_value,

            'min_age'=>$this->min_age,
            'min_age_unit'=>$this->min_age_unit,

            'max_age'=>$this->max_age,
            'max_age_unit'=>$this->max_age_unit,

            'gender'=>$this->gender,
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
