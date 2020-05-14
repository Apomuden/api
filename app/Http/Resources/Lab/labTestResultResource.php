<?php

namespace App\Http\Resources\Lab;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class labTestResultResource extends JsonResource
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
        return [
            'id'=>$this->id,
            'folder_no' => (($folder->folder_no ?? null) . ($patient->postfix ?? null)) ?? null,
            'patient_title' => $patient->title->name ?? null,
            'patient_name' => $patient->fullname ?? null,
            'gender' => $this->investigation->gender ?? null,
            'age' => $this->investigation->age ?? null,
            'age_group' => $this->age_group->name ?? null,

            'age_category' => $this->age_category->name ?? null,
            'age_category_id' => $this->age_category_id ?? null,

            'age_class_name' => $this->age_classification->name ?? null,
            'age_class_id' => $this->age_class_id ?? null,

            'patient_status' => $this->investigation->patient_status ?? null,
            'investigation_id'=>$this->investigation_id,
            'consultation_id'=>$this->investigation->consultation_id??null,
            'hospital_service_name' => $this->service->hospital_service->name,
            'hospital_service_id' => $this->service->hospital_service->id,
            'service_category_name' => $this->service->service_category->name??null,
            'service_category_id' => $this->service->service_category->id??null,
            'service_subcategory_name' => $this->service->service_subcategory->name ?? null,
            'service_subcategory_id' => $this->service->service_subcategory->id ?? null,
            'service_name' => $this->service->description ?? null,
            'service_id' => $this->service->id ?? null,
            'lab_parameter_id'=>$this->lab_parameter_id,
            'lab_parameter_name'=>$this->lab_parameter_name??null,
            'lab_parameter_description'=>$this->lab_parameter_description??null,
            'value_type'=>$this->value_type??null,
            'test_value'=>$this->test_value??null,
            'parameter_order'=>$this->parameter_order??null,
            'lab_parameter_range_id'=>$this->lab_parameter_range_id??null,
            'flag'=>$this->flag ??null,
            'range_text_value'=>$this->range_text_value ??null,
            'min_comparator'=>$this->min_comparator  ??null,
            'min_value'=>$this->min_value  ??null,
            'max_comparator'=>$this->max_comparator   ??null,
            'max_value'=>$this->max_value   ??null,
            'min_age'=>$this->min_age   ??null,
            'min_age_unit'=>$this->min_age_unit   ??null,
            'max_age'=>$this->max_age   ??null,
            'max_age_unit'=>$this->max_age_unit    ??null,
            'status' => $this->status,
            'technician_id'=>$this->technician_id,
            'technician_name'=>$this->technician->fullname??null,
            'user_id'=>$this->user_id,
            'user_name'=>$this->user->fullname??null,
            'approver_id'=>$this->approver_id,
            'approver_name'=>$this->approver->fullname??null,
            'approval_date'=> $this->approval_date? DateHelper::toDisplayDateTime($this->approval_date):null,
            'canceller_id' => $this->canceller_id,
            'canceller_name' => $this->canceller->fullname ?? null,
            'cancelled_date'=> $this->cancelled_date? DateHelper::toDisplayDateTime($this->cancelled_date):null,
            'test_date' => $this->test_date? DateHelper::toDisplayDateTime($this->test_date):null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}