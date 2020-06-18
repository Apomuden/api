<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NhisProviderTariffResource extends JsonResource
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
            'nhis_provider_level_id'=>$this->nhis_provider_level_id,
            'tariff'=>$this->tariff
        ];
    }
}
