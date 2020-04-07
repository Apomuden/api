<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class DiagnosisMultipleRequest extends ApiFormRequest
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
        $id = $this->route('diagnosis') ?? null;
        return [
            "consultation_id" => 'bail|integer|' . ($id ? 'sometimes' : 'required').'|exists:consultations,id',
            'diagnoses' => 'bail|required|array',
            "diagnoses.*.disease_id" => 'bail|integer|distinct|' . ($id ? 'sometimes' : 'required') . '|exists:diseases,id',
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT',
            'consultation_date' => 'bail|sometimes|date',
            'diagnoses.*.patient_diagnoses'=>'bail|string|'. ($id ? 'sometimes' : 'required'),
            'diagnoses.*.diagnosis_type'=> 'bail|string|'. ($id ? 'sometimes' : 'required').'|in:CONFIRM,PROVISIONAL,ADDITIONAL',
            'diagnoses.*.diagnosis_status'=> 'bail|'. ($id ? 'sometimes' : 'required').'|nullable|in:NEW,OLD',
            'diagnoses.*.remarks'=> 'bail|sometimes|nullable',
            'consultant_id' => ['bail', 'sometimes', 'nullable', Rule::exists('users', 'id')],
        ];
    }


}
