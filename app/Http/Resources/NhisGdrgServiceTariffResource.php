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
            // 'nhis_provider_level_id'=>$this->nhis_provider_level_id,
            // 'nhis_provider_level_name'=>$this->nhis_provider_level->name??null,
            'major_diagnostic_category_id'=> $this->major_diagnostic_category_id,
            'major_diagnostic_category_name'=>$this->major_diagnostic_category->description,
            'mdc_code'=>$this->mdc_code,
            // 'tariff'=>floatval($this->tariff),
            'hospital_service_id'=>$this->hospital_service_id,
            'hospital_service_name'=>$this->hospital_service->name,
            'patient_status'=>$this->patient_status,
            'gender'=>$this->gender,
            'age_group_id'=>$this->age_group_id,
            'age_group_name'=>$this->age_group->name,
            'tariff_type'=>$this->tariff_type,
            'nhis_provider_levels'=>NhisProviderTariffResource::collection($this->nhis_provider_level_tariffs),
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
