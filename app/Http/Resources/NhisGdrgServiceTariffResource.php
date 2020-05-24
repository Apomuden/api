<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class NhisGdrgServiceTariffResource extends JsonResource
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
            'gdrg_code'=>$this->gdrg_code,
            'gdrg_service_name'=>$this->gdrg_service_name,
            'primary_with_catering'=>round($this->primary_with_catering),
            'primary_no_catering'=> round($this->primary_no_catering),
            'secondary_with_catering'=> round($this->secondary_with_catering),
            'secondary_no_catering'=> round($this->secondary_no_catering),
            'tertiary_with_catering'=> round($this->tertiary_with_catering),
            'tertiary_no_catering'=> round($this->tertiary_no_catering),
            'major_diagnostic_category_id'=> $this->major_diagnostic_category_id,
            'major_diagnostic_category_name'=>$this->major_diagnostic_category->description,
            'mdc_code'=>$this->mdc_code,
            'hospital_service_id'=>$this->hospital_service_id,
            'hospital_service_name'=>$this->hospital_service->name,
            'patient_status'=>$this->patient_status,
            'gender'=>$this->gender,
            'age_group_id'=>$this->age_group_id,
            'age_group_name'=>$this->age_group->name,
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
