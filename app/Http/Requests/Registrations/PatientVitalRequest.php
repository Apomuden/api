<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;

class PatientVitalRequest extends ApiFormRequest
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
        $id = $this->route('patientvital') ?? null;
        return [
            'patient_id' => 'bail|'.($id?'sometimes':'required').'|integer|exists:patients,id|'.$this->softUniqueWith('patient_vitals','patient_id,created_at',$id),
            'temperature' => 'bail|sometimes|nullable|numeric',
            'pulse' => 'bail|sometimes|nullable|numeric',
            'systolic_blood_pressure' => 'bail|sometimes|nullable|numeric',
            'diastolic_blood_pressure' => 'bail|sometimes|nullable|numeric',
            'respiration' => 'bail|sometimes|nullable|numeric',
            'weight' => 'bail|sometimes|nullable|numeric',
            'height' => 'bail|sometimes|nullable|numeric',
            'bmi' => 'bail|sometimes|nullable|numeric',
            'oxygen_saturation' => 'bail|sometimes|nullable|numeric',
            'fasting_blood_sugar' => 'bail|sometimes|nullable|numeric',
            'random_blood_sugar' => 'bail|sometimes|nullable|numeric',
            'comment' => 'bail|sometimes|nullable|string',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}
