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
            'age_group' => $patient->age_group->name ?? null,
            'age' => $this->investigation->age ?? null,
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
            'min_comparator'=>$this->min_comparator  ??null,
            'min_value'=>$this->min_value  ??null,
            'max_comparator'=>$this->max_comparator   ??null,
            'max_value'=>$this->max_value   ??null,
            'min_age'=>$this->min_age   ??null,
            'min_age_unit'=>$this->min_age_unit   ??null,
            'max_age'=>$this->max_age   ??null,
            'max_age_unit'=>$this->max_age_unit    ??null,

            'technician_id'=>$this->technician_id,
            'technician_name'=>$this->technician->fullname??null,
            'user_id'=>$this->user_id,
            'user_name'=>$this->user->fullname??null,
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
