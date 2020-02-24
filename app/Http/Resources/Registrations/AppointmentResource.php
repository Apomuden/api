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
                'doctor_id'=>$doctor->id??null,
                'attendance_date'=>DateHelper::toDisplayDateTime($this->attendance_date),
                'entered_by'=>$entry_user->id??null,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at),
            ];
        }
        return null;
    }
}
