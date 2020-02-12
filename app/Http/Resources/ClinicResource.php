<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
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
            $age_group = $this->age_group;
            $main_clinic=$this->main_clinic;

            return [
                'id' => $this->id,
                'name' => $this->name,
                'age_group_name' => $age_group->name??null,
                'age_group_id' => $age_group->id??null,
                'main_clinic_name'=>$main_clinic->name??null,
                'main_clinic_id'=>$main_clinic->id??null,
                'gender' => $this->gender,
                'status' => $this->status,
                'patient_status' => $this->patient_status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return NULL;
    }
}
