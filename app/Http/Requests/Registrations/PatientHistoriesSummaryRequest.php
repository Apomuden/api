<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientHistoriesSummaryRequest extends ApiFormRequest
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
        $id = $this->route('patienthistorysummary') ?? null;

        return [
            "patient_id" => 'bail|integer|' . ($id ? 'sometimes' : 'required') . '|exists:patients,id|' . $this->softUnique('patient_histories_summaries', 'patient_id', $id),
            'patient_status' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:IN-PATIENT,OUT-PATIENT',
            'past_medical_history' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|nullable',
            'surgical_history' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|nullable',
            'medicine_history' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|nullable',
            'allergies_history' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|nullable',
            'family_history' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|nullable',
            'social_history' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|nullable'
        ];
    }
}
