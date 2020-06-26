<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class PreviousPregnancyRequest extends ApiFormRequest
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
        $id = $this->route('previous_pregnancy') ?? null;

        return [
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id',
            'consultation_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:consultations,id',
            'patient_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT',
            'date' => 'bail|' . ($id ? 'sometimes' : 'required') . '|date',
            'problem_during_pregnancy' => 'bail|sometimes|nullable|string',
            'birth_place_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:obs_birth_places,id',
            'gestational_week_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:gestational_weeks,id',
            'delivery_mode_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:delivery_modes,id',
            'delivery_outcome_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:delivery_outcomes,id',
            'labour_postpartum_complication' => 'bail|sometimes|nullable|string',
            'gender' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:MALE,FEMALE',
            'birth_weight' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric|min:0',
            'child_health' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:GOOD,POOR,DEAD',
        ];
    }
}
