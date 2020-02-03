<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
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
            $clinic_consult_service = $this->clinic_consult_service;
            $user = $this->user;
            $patient = $this->patient;
            $funding_type = $this->funding_type;
            $age_group = $this->age_group;
            $sponsorship_type = $this->sponsorship_type;

            return [
                'id' => $this->id,
                'consultation_given'=>$this->consultation_given,
                'consultation_service_name'=>$clinic_consult_service->name??null,
                'consultation_service_id'=>$clinic_consult_service->id??null,
                'patient_name'=>$patient->name??null,
                'patient_id'=>$patient->id??null,
                'funding_type_name'=>$funding_type->name??null,
                'funding_type_id'=>$funding_type->id??null,
                'sponsorship_type_name'=>$sponsorship_type->name??null,
                'sponsorship_type_id'=>$sponsorship_type->id??null,
                'age_group_name'=>$age_group->name??null,
                'age_group_id'=>$age_group->id??null,
                'user_id'=>$user->id??null,
                'service_quantity'=>$this->service_quantity,
                'service_fee'=>$this->service_fee,
                'age'=>$this->age,
                'attendance_date' => DateHelper::toDisplayDateTime($this->attendance_date),
                'started_at' => DateHelper::toDisplayDateTime($this->started_at),
                'ended_at' => DateHelper::toDisplayDateTime($this->ended_at),
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
                'status'=>$this->status
            ];
        }
    }
}