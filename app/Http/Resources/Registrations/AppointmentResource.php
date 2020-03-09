<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            $doctor = $this->doctor;
            $patient = $this->patient;
            $entry_user = $this->entry_user;
            return [
                'id'=>$this->id,
                'patient_id'=>$patient->id??null,
                'patient'=> [
                    'id'=>$patient->id??null,
                    'surname'=>$patient->surname??null,
                    'middlename'=>$patient->middlename??null,
                    'firstname'=>$patient->firstname??null,
                    'active_cell'=>$patient->active_cell??null,
                    'email'=>$patient->email??null,
                    'residential_address'=>$patient->residential_address??null
                ],
                'doctor_id'=>$doctor->id??null,
                'doctor'=> [
                    'id'=>$doctor->id??null,
                    'staff_id'=>$doctor->staff_id??null,
                    'surname'=>$doctor->surname??null,
                    'middlename'=>$doctor->middlename??null,
                    'firstname'=>$doctor->firstname??null,
                    'active_cell'=>$doctor->active_cell
                ],
                'staff_specialty_name'=>$this->staff_specialty->name??null,
                'staff_specialty_id'=>$this->staff_specialty->id??null,
                'enquirer_name'=>$this->enquirer_name,
                'enquirer_phone'=>$this->enquirer_phone,
                'enquirer_email'=>$this->enquirer_email,
                'enquirer_residence'=>$this->enquirer_residence,
                'attendance_date'=>DateHelper::toDisplayDateTime($this->attendance_date),
                'entered_by'=>$entry_user->id??null,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }
        return null;
    }
}
