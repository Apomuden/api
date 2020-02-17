<?php

namespace App\Http\Resources\Clinic;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $patient=$this->patient;
        $folder = $patient->activefolder;
        $age_class=$this->age_class;
        $age_group=$this->age_group;
        $funding_type=$this->funding_type;
        $sponsorship_type=$this->sponsorship_type;
        $billing_sponsor=$this->billing_sponsor;
        $clinic_type=$this->clinic_type;
        $clinic=$this->clinic;
        return [
            'id'=>$this->id,
            'folder_no' => (($folder->folder_no ?? null) . ($patient->postfix ?? null)) ?? null,
            'patient_title'=>$patient->title->name??null,
            'patient_name'=>$patient->fullname??null,
            'gender'=>$this->gender??null,
            'age'=>$this->age??null,
            'age_class_name'=>$age_class->name??null,
            'age_class_id'=>$age_class->id??null,
            'age_group_name'=>$age_group->name??null,
            'age_group_id'=>$age_group->id??null,
            'patient_status'=>$this->patient_status,
            'request_type'=>$this->request_type,
            'insured'=>$this->insured??null,
            'funding_type'=>$funding_type->name??null,
            'funding_id'=>$funding_type->id??null,
            'sponsorship_type_name'=>$sponsorship_type->name,
            'sponsorship_type_id'=> $sponsorship_type->id,
            'sponsor_name'=> $billing_sponsor->name??null,
            'sponsor_id'=> $billing_sponsor->id??null,
            'clinic_type_name'=>$clinic_type->name??null,
            'clinic_type_id'=>$clinic_type->id??null,
            'clinic_name'=>$clinic->name??null,
            'clinic_id'=>$clinic->id??null,
            'attendance_date'=> DateHelper::toDisplayDateTime($this->attendance_date),
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
