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
            $clinic_consult_service = $this->service;
            $patient = $this->patient;
            $funding_type = $this->funding_type;
            $age_group = $this->age_group;
            $sponsorship_type = $this->sponsorship_type;
            $billing_sponsor = $this->billing_sponsor;
            $patient_sponsor = $this->patient_sponsor;
            $clinic = $this->clinic;
            $clinic_type = $this->clinic_type;
            $consultant = $this->consultant;
            $age_class = $this->age_class;

            return [
                'id' => $this->id,
                'order_type' => $this->order_type,
                'consultation_given' => $this->consultation_given,
                'consultation_service_name' => $clinic_consult_service->name ?? null,
                'consultation_service_id' => $clinic_consult_service->id ?? null,
                'consultant_name' => $consultant->name ?? null,
                'consultant_id' => $consultant->id ?? null,
                'clinic_name' => $clinic->name ?? null,
                'clinic_id' => $clinic->id ?? null,
                'clinic_type_name' => $clinic_type->name ?? null,
                'clinic_type_id' => $clinic_type->id ?? null,
                'patient_name' => $patient->fullname ?? null,
                'patient_id' => $patient->id ?? null,
                'funding_type_name' => $funding_type->name ?? null,
                'funding_type_id' => $funding_type->id ?? null,
                'sponsorship_type_name' => $sponsorship_type->name ?? null,
                'sponsorship_type_id' => $sponsorship_type->id ?? null,
                'billing_sponsor_name' => $billing_sponsor->name ?? null,
                'billing_sponsor_id' => $billing_sponsor->id ?? null,
                'patient_sponsor_name' => $patient_sponsor->name ?? null,
                'patient_sponsor_id' => $patient_sponsor->id ?? null,
                'age_class_id' => $this->age_class_id ?? null,
                'age_class_name' => $age_class->name ?? null,
                'user_name' => $this->user->fullname ?? null,
                'user_id' => $this->user_id ?? null,
                'service_quantity' => $this->service_quantity,
                'service_fee' => $this->service_fee,
                'age_group' => $age_group->name ?? null,
                'age' => $this->age,
                'member_id' => $this->member_id,
                'ccc' => $this->ccc,
                'attendance_date' => DateHelper::toDisplayDateTime($this->attendance_date),
                'patient_status' => $this->patient_status,
                'started_at' => DateHelper::toDisplayDateTime($this->started_at),
                'ended_at' => DateHelper::toDisplayDateTime($this->ended_at),
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
                'status' => $this->status
            ];
        }
    }
}
