<?php

namespace App\Http\Resources\Lab;

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
            'flag'=>$this->flag,
            'min_comparator'=>$this->min_comparator,
            'min_value'=>$this->min_value,
            'max_comparator'=>$this->max_comparator,
            'max_value'=>$this->max_value,
            'age_group_id'=>$this->age_group_id,
            'age_group_name'=>$this->age_group->name,
            'gender'=>$this->gender,
            'status'=>$this->status
        ];
    }
}
