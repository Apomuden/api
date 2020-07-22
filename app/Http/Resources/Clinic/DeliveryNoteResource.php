<?php

namespace App\Http\Resources\Clinic;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryNoteResource extends JsonResource
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

        $user = $this->user;
        $funding_type = $this->funding_type ?? null;

        $sponsorship_type = $this->sponsorship_type ?? null;
        $billing_sponsor = $this->billing_sponsor ?? null;
        $sponsorship_policy = $this->sponsorship_policy ?? null;
        $clinic_type = $this->clinic_type ?? null;
        $clinic = $this->clinic ?? null;
        $consultant = $this->consultant ?? null;
        $canceller = $this->canceller ?? null;

        return [
            'id' => $this->id,
            'folder_no' => (($folder->folder_no ?? null) . ($patient->postfix ?? null)) ?? null,
            'patient_title' => $patient->title->name ?? null,
            'patient_name' => $patient->fullname ?? null,
            'gender' => $this->gender ?? null,
            'age_group' => $this->age_group->name ?? null,

            'age_category' => $this->age_category->name ?? null,
            'age_category_id' => $this->age_category_id ?? null,

            'age_class_name' => $this->age_classification->name ?? null,
            'age_class_id' => $this->age_class_id ?? null,

            'consultation_id' => $this->consultation_id,
            'consultation_service_name' => $this->consultation->service->description ?? null,
            'consultation_service_id' => $this->consultation->consultation_service_id ?? null,

            'age' => $this->age ?? null,
            'patient_status' => $this->patient_status ?? null,

            'order_type' => $this->order_type,

            'clinic_type_name' => $clinic_type->name ?? null,
            'clinic_type_id' => $clinic_type->id ?? null,

            'clinic_name' => $clinic->name ?? null,
            'clinic_id' => $clinic->id ?? null,

            'user_name' => $user->fullname,
            'user_id' => $user->id,

            'funding_type_name' => $funding_type->name ?? null,
            'funding_type_id' => $funding_type->id ?? null,

            'sponsorship_type_name' => $sponsorship_type->name ?? null,
            'sponsorship_type_id' => $sponsorship_type->id ?? null,

            'billing_sponsor_name' => $billing_sponsor->name ?? null,
            'billing_sponsor_id' => $billing_sponsor->id ?? null,

            'sponsorship_policy_name' => $sponsorship_policy->name ?? null,
            'sponsorship_policy_id' => $sponsorship_policy->id ?? null,

            'consultant_name' => $consultant->fullname ?? null,
            'consultant_id' => $consultant->id ?? null,

            'canceller_name' => $canceller->fullname ?? null,
            'canceller_id' => $canceller->id ?? null,

            'cancelled_date' => $this->cancelled_date ? (string) $this->cancelled_date : null,
            'notes' => $this->notes,
            'delivery_date' => $this->delivery_date ? DateHelper::toDisplayDateTime($this->delivery_date) : null,
            'status' => $this->status,
            'consultation_date' => DateHelper::toDisplayDateTime($this->consultation_date),
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
