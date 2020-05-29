<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class MajorDiagnosticCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id)){
            return [
                'id'=>$this->id,
                'desciption'=>$this->description,
                'mdc_code'=>$this->mdc_code,
                'hospital_service_id'=>$this->hospital_service_id,
                'hospital_service_name'=>$this->hospital_service->name,
                'patient_status'=>$this->patient_status,
                'gender'=>$this->gender,
                'age_group_id'=>$this->age_group_id,
                'age_group_name'=>$this->age_group->name,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        else
           return NULL;
    }
}
