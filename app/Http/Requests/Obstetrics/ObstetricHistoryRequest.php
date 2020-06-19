<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class ObstetricHistoryRequest extends ApiFormRequest
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
        $id = $this->route('obstetric_history') ?? null;

        return [
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id',
            'consultation_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:consultations,id',
            'abortions' => 'bail|sometimes|nullable|numeric|min:1',
            'deceased' => 'bail|sometimes|nullable|numeric|min:1',
            'full_term' => 'bail|sometimes|nullable|numeric|min:1',
            'gravida' => 'bail|sometimes|nullable|numeric|min:1',
            'induced' => 'bail|sometimes|nullable|numeric|min:1',
            'living' => 'bail|sometimes|nullable|numeric|min:1',
            'multiple_birth' => 'bail|sometimes|nullable|numeric|min:1',
            'patient_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT',
            'premature' => 'bail|sometimes|nullable|numeric|min:1',
            'spontaneous' => 'bail|sometimes|nullable|numeric|min:1',
        ];
    }
}
