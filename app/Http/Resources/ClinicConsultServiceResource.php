<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicConsultServiceResource extends JsonResource
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
            $clinic = $this->clinic;
            $service_category = $this->service_category;
            $billing_cycle = $this->billing_cycle;

            return [
                'id' => $this->id,
                'display_name' => $this->name ?? $service_category->name ?? null,
                'clinic_name' => $clinic->name ?? null,
                'clinic_id' => $this->clinic_id ?? null,
                'billing_cycle_name' => $billing_cycle->name ?? null,
                'billing_cycle_id' => $this->billing_cycle_id ?? null,
                'service_category_name' => $service_category->name ?? null,
                'service_category_id' => $this->service_category_id ?? null,
                'price' => doubleval($this->price),
                'duration' => $this->duration,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }

        return null;
    }
}
