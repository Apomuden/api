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
            $hospital_service = $this->hospital_services;
            $service_price = $this->service_prices;

            return [
                'id' => $this->id,
                'name' => $this->name,
                'hospital_service_name' => $hospital_service->name ?? null,
                'hospital_service_id' => $hospital_service->id ?? null,
                'service_price' => $service_price->amount ?? null,
                'service_price_id' => $service_price->id ?? null,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        } else {
            return NULL;
        }
    }
}
