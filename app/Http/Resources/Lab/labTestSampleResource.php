<?php

namespace App\Http\Resources\Lab;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class labTestSampleResource extends JsonResource
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
            'sample_code'=>$this->sample_code,
            'lab_sample_type_id'=>$this->lab_sample_type_id,
            'lab_sample_type_name'=>$this->lab_sample_type->name??null,
            'lab_sample_type_order'=>$this->lab_sample_type_order??null,
            'technician_id'=>$this->technician_id,
            'technician_name'=>$this->technician->fullname??null,
            'user_id'=>$this->user_id,
            'user_name'=>$this->user->fullname??null,
            'approver_id'=>$this->approver_id,
            'approver_name'=>$this->approver->fullname??null,
            'approval_date'=> $this->approval_date? DateHelper::toDisplayDateTime($this->approval_date):null,
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
