<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicAttributeResource extends JsonResource
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
            $clinic = $this->clinic;
            $service_category = $this->service_category;
            $billing_cycle = $this->billing_cycle;

            return [
                'id' => $this->id,
                'clinic_name' => $clinic->name,
                'age_group_id' => $clinic->age_group_id,
                'gender' => $clinic->gender,
                'patient_status' => $clinic->patient_status,
                'clinic_id' => $this->clinic_id,
                'service_category_name' => $service_category->name,
                'service_category_id' => $this->service_category_id,
                'billing_cycle_name' => $billing_cycle->name,
                'billing_cycle_id' => $this->billing_cycle_id,
                'duration' => $this->duration,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        } else {
            return NULL;
        }
    }
}
