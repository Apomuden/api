<?php

namespace App\Http\Resources\Obstetrics;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed created_at
 * @property mixed updated_at
 * @property mixed id
 * @property mixed patient
 * @property mixed patient_status
 * @property mixed ice_driver_phone
 * @property mixed partner_dob
 * @property mixed partner_region
 * @property mixed partner_district
 * @property mixed partner_name
 * @property mixed partner_educational_level
 * @property mixed partner_phone
 * @property mixed partner_residence
 * @property mixed partner_occupation
 * @property mixed ice_name
 * @property mixed ice_phone
 * @property mixed user
 * @property mixed user_id
 * @property mixed patient_id
 * @property mixed patient_age
 * @property mixed consultation_id
 */
class ObsFamilyInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $dob = null;
        if (isset($this->partner_dob))
            $dob = DateHelper::toDisplayDateTime($this->partner_dob);
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
//            'patient' => $this->patient,
            'consultation_id' => $this->consultation_id,

            'patient_status' => $this->patient_status,
            'partner_name' => $this->partner_name,
            'partner_dob' => $dob,
            'patient_age' => $this->patient_age,
            'partner_region' => $this->partner_region,
            'partner_district' => $this->partner_district,
            'partner_educational_level' => $this->partner_educational_level,
            'partner_residence' => $this->partner_residence,
            'partner_phone' => $this->partner_phone,
            'partner_occupation' => $this->partner_occupation,

            'ice_name' => $this->ice_name,
            'ice_phone' => $this->ice_phone,
            'ice_driver_phone' => $this->ice_driver_phone,

            'user_id' => $this->user_id,
//            'user' => $this->user,

            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
