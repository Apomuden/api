<?php

namespace App\Http\Requests\Lab;

use App\Http\Helpers\DateHelper;
use App\Http\Resources\Lab\labTestResultSimpleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestigationResultHierarchicalResource extends JsonResource
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
        $folder = $patient->activefolder ?? null;
        $hospital_service = $this->hospital_service;
        $service_category = $this->service_category;
        $service_subcategory = $this->service_subcategory;
        $service = $this->service;
        $user = $this->user;
        $funding_type = $this->funding_type;

        $sponsorship_type = $this->sponsorship_type;
        $billing_sponsor = $this->billing_sponsor;
        $sponsorship_policy = $this->sponsorship_policy;
        $clinic_type = $this->clinic_type;
        $clinic = $this->clinic;
        $consultant = $this->consultant;

        $canceller = $this->canceller;

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

            'age' => $this->age ?? null,
            'patient_status' => $this->patient_status ?? null,

            'order_type'=>$this->order_type,

            'clinic_type_name' => $clinic_type->name ?? null,
            'clinic_type_id' => $clinic_type->id ?? null,

            'clinic_name' => $clinic->name ?? null,
            'clinic_id' => $clinic->id ?? null,

            'hospital_service_name' => $hospital_service->name,
            'hospital_service_id' => $hospital_service->id,

            'service_category_name' => $service_category->name,
            'service_category_id' => $service_category->id,

            'service_subcategory_name' => $service_subcategory->name ?? null,
            'service_subcategory_id' => $service_subcategory->id ?? null,

            'service_name' => $service->description ?? null,
            'service_id' => $service->id ?? null,

            'user_name' => $user->fullname,
            'user_id' => $user->id,

            'prepaid_total' => round($this->prepaid_total,2) ?? 0.00,
            'postpaid_total' => round($this->postpaid_total,2) ?? 0.00,

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

            'status' => $this->status,
            'consultation_date' => DateHelper::toDisplayDateTime($this->consultation_date),
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
            'results'=>labTestResultSimpleResource::collection($this->lab_test_results)
        ];
    }
}
