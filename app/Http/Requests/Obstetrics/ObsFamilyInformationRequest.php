<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class ObsFamilyInformationRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('family_information') ?? null;
        return [
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id',
            'consultation_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:consultations,id',

            'partner_name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'partner_dob' => 'bail|sometimes|date',
            'partner_phone' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'partner_residence' => 'bail|sometimes|string',
            'partner_occupation' => 'bail|sometimes|string',

            'partner_district_id' => 'bail|sometimes|integer|exists:districts,id',
            'partner_region_id' => 'bail|sometimes|integer|exists:regions,id',
            'partner_educational_level_id' => 'bail|sometimes|integer|exists:educational_levels,id',

            'ice_name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'ice_phone' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'ice_driver_phone' => 'bail|sometimes|string',
            'patient_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT',
        ];
    }
}
