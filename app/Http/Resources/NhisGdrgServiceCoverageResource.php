<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class NhisGdrgServiceCoverageResource extends JsonResource
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
            'gdrg_code'=>$this->nhis_gdrg_service_tariff->gdrg_code,
            'gdrg_service_name'=>$this->nhis_gdrg_service_tariff->gdrg_service_name,
            'mdc_code'=>$this->nhis_gdrg_service_tariff->mdc_code,
            'out_patient'=>$this->out_patient,
            'in_patient'=>$this->in_patient,
            'surgery'=>$this->surgery,
            'non_surgery'=>$this->non_surgery,
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
