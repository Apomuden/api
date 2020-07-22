<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientNextOfKinResource extends JsonResource
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
        $relationship=$this->relationship;
        return [
             'id'=>$this->id,
             'name'=>$this->name,
             'phone'=>$this->phone,
             'email'=>$this->email,
             'patient_id'=>$patient->id??null,
             'patient_name'=>$patient->fullname??null,
             'patient_phone'=>$patient->phone??null,
             'folder_no'=>$patient->activefolder->folder_no??null,
             'relation_id'=>$relationship->id??null,
             'relation_name'=>$relationship->name??null,
             'address'=>$this->address??null,
             'status'=>$this->status,
             'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
             'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
