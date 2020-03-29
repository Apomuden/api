<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $patient = $this->patient;
        $funding_type = $this->funding_type;

        $sponsorship_type = $this->sponsorship_type;
        $billing_sponsor = $this->billing_sponsor;
        $clinic = $this->clinic;
        $clinic_type = $this->clinic_type;
        $consultant = $this->consultant;

        $category=$this->category;
        $type=$this->type;
        return [
            'id' => $this->id,
            'consultation_id' => $this->consultation_id,
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
            'gender' => $this->gender,
            'age' => $this->age,
            'consultation_date' => DateHelper::toDisplayDateTime($this->consultation_date),
            'attendance_date' => DateHelper::toDisplayDateTime($this->attendance_date),
            'patient_status' => $this->patient_status,
            'exam_status' => $this->exam_status??null,
            'fundings' => $this->fundings??null,
            'type_id' => $this->type_id,
            'type_name' => $type->name ?? null,

            'category_id' => $this->category_id,
            'category_name' => $category->name ?? null,

            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
