<?php

namespace App\Http\Resources\Clinic;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientNoteSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $patient = $this->patient ?? null;
        $folder = $patient->activefolder ?? null;

        $user = $this->user??null;
        $funding_type = $this->funding_type??null;

        $sponsorship_type = $this->sponsorship_type??null;
        $billing_sponsor = $this->billing_sponsor??null;
        $sponsorship_policy = $this->sponsorship_policy??null;


        return isset($this->id)?[
            'patient_id' => $this->patient_id,
            'folder_no' => (($folder->folder_no ?? null) . ($patient->postfix ?? null)) ?? null,
            'patient_title' => $patient->title->name ?? null,
            'patient_name' => $patient->fullname ?? null,
            'gender' => $this->gender ?? null,
            'age_group' => $this->age_group->name ?? null,

            'age_category' => $this->age_category->description ?? null,
            'age_category_id' => $this->age_category_id ?? null,

            'age_class_name' => $this->age_class->name ?? null,
            'age_class_id' => $this->age_class_id ?? null,


            'age' => $this->age ?? null,
            'patient_status' => $this->patient_status ?? null,

            'order_type' => $this->order_type,

            'user_name' => $user->fullname??null,
            'user_id' => $user->id??null,

            'funding_type_name' => $funding_type->name ?? null,
            'funding_type_id' => $funding_type->id ?? null,

            'sponsorship_type_name' => $sponsorship_type->name ?? null,
            'sponsorship_type_id' => $sponsorship_type->id ?? null,

            'billing_sponsor_name' => $billing_sponsor->name ?? null,
            'billing_sponsor_id' => $billing_sponsor->id ?? null,

            'sponsorship_policy_name' => $sponsorship_policy->name ?? null,
            'sponsorship_policy_id' => $sponsorship_policy->id ?? null,

            'treatment_plan'=>$this->treatment_plan,
            'physician_note'=>$this->physician_note,
            'nursing_note'=>$this->nursing_note,
            'delivery_note'=>$this->delivery_note,
            'procedure_note'=>$this->procedure_note,
            'admission_note'=>$this->admission_note,
            'progress_note'=>$this->progress_note,
            'urgent_care_note'=>$this->urgent_care_note,
            'status' => $this->status,
            'consultation_date' => DateHelper::toDisplayDateTime($this->consultation_date),
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ]:null;
    }
}
