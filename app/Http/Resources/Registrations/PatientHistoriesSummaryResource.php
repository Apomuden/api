<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientHistoriesSummaryResource extends JsonResource
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


        return [
            'id' => $patient->id ?? null,
            'patient_name' => $patient->fullname ?? null,
            'funding_type_name' => $funding_type->name ?? null,
            'funding_type_id' => $funding_type->id ?? null,
            'sponsorship_type_name' => $sponsorship_type->name ?? null,
            'sponsorship_type_id' => $sponsorship_type->id ?? null,
            'billing_sponsor_name' => $billing_sponsor->name ?? null,
            'billing_sponsor_id' => $billing_sponsor->id ?? null,
            'gender'=>$this->gender,
            'age'=>$this->age,
            'patient_status' => $this->patient_status,
            'presenting_complaints_history'=>$this->presenting_complaints_history??null,
            'past_medical_history'=>$this->past_medical_history??null,
            'surgical_history'=>$this->surgical_history??null,
            'medicine_history'=>$this->medicine_history??null,
            'allergies_history'=>$this->allergies_history??null,
            'family_history'=>$this->family_history??null,
            'social_history'=>$this->social_history??null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
