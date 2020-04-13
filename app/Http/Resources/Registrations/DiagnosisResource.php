<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class DiagnosisResource extends JsonResource
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
        $age_group = $this->age_group;
        $sponsorship_type = $this->sponsorship_type;
        $billing_sponsor = $this->billing_sponsor;
        $patient_sponsor = $this->patient_sponsor;
        $clinic = $this->clinic;
        $clinic_type = $this->clinic_type;
        $consultant = $this->consultant;
        return [
            'id'=>$this->id,
            'disease_id'=>$this->disease_id,
            'disease_name'=>$this->disease->name??null,

            'consultation_id'=>$this->consultation_id,

            'disease_code'=>$this->disease_code??null,

            'icd10_code'=>$this->icd10_code??null,
            'icd10_grouping_code'=>$this->icd10_grouping_code??null,
            'icd10_grouping_code'=>$this->icd10_grouping_code??null,

            'icd10_grouping_id'=>$this->icd10_grouping_id??null,
            'icd10_grouping_name'=>$this->icd10_grouping->name??null,

            'icd10_category_id'=>$this->icd10_category_id??null,
            'icd10_category_name'=>$this->icd10_category->name??null,

            'moh_ghs_grouping_id'=>$this->moh_ghs_grouping_id??null,
            'moh_ghs_grouping_name'=>$this->moh_ghs_grouping->name??null,

            'moh_grouping_code'=>$this->moh_grouping_code??null,

            'require_surgery'=>$this->require_surgery??null,
            'require_investigation'=>$this->require_investigation??null,
            'adult_gdrg'=>$this->adult_gdrg??null,
            'adult_tariff'=>$this->adult_tariff??null,
            'child_gdrg'=>$this->child_gdrg??null,
            'child_tariff'=>$this->child_tariff??null,
            'remarks'=>$this->remarks??null,

            'diagnosis_type'=>$this->diagnosis_type,
            'diagnosis_status'=>$this->diagnosis_status,


            'consultant_name' => $consultant->fullname ?? null,
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
            'age_group' => $age_group->name ?? null,
            'age' => $this->age,
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
