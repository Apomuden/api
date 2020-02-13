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
        $clinic=$this->clinic??null;
        $main_clinic=$this->main_clinic??null;
        $consultation_service=$this->consultation_service??null;
        $billing_cycle=$this->billing_cycle??null;
        return [
            'id'=>$this->id??null,
            'clinic_name'=>$clinic->name??null,
            'clinic_id'=>$clinic->id??null,
            'main_clinic_name'=>$main_clinic->name??null,
            'main_clinic_id'=>$main_clinic->id??null,
            'consultation_service_name'=> $consultation_service->name??null,
            'consultation_service_id'=> $consultation_service->id??null,
            'billing_cycle_name'=> $billing_cycle->name??null,
            'billing_cycle_id'=> $billing_cycle->id??null,
            'billing_duration'=> $this->billing_duration??null,
            'status'=>$this->status??null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at??null),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at??null)
        ];
    }
}
