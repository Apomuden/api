<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $clinic = $this->clinic ?? null;
        $clinic_type = $this->clinic_type ?? null;
        //$consultation_service=$this->consultation_service??null;
        $billing_cycle = $this->billing_cycle ?? null;
        $service_category = $this->service_category ?? null;
        $service_subcategory = $this->service_subcategory ?? null;
        $service = $this->service ?? null;
        if (isset($this->id)) {
            return [
            'id' => $this->id ?? null,
            'clinic_name' => $clinic->name ?? null,
            'clinic_id' => $clinic->id ?? null,
            'clinic_type_name' => $clinic_type->name ?? null,
            'clinic_type_id' => $clinic_type->id ?? null,
            "service_category_name" => $service_category->name ?? null,
            "service_category_id" => $service_category->id ?? null,
            "service_subcategory_name" => $service_subcategory->name ?? null,
            "service_subcategory_id" => $service_subcategory->id ?? null,
            "service_name" => $service->description ?? null,
            "service_id" => $service->id ?? null,
            'billing_cycle_name' => $billing_cycle->name ?? null,
            'billing_cycle_id' => $billing_cycle->id ?? null,
            'billing_duration' => $this->billing_duration ?? null,
            'status' => $this->status ?? null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at ?? null),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at ?? null)
            ];
        }
    }
}
