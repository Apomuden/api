<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientHistoryRequest extends ApiFormRequest
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
        $id = $this->route('patienthistory') ?? null;
        return [
            "consultation_id" => 'bail|integer|' . ($id ? 'sometimes' : 'required'),
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT',
            'consultation_date' => 'bail|sometimes|date',
            'presenting_complaints' => 'bail|sometimes|string|nullable',
            'presenting_complaints_history' => 'bail|sometimes|string|nullable',
            'direct_questions' => 'bail|sometimes|string|nullable',
            'past_medical_history' => 'bail|sometimes|string|nullable',
            'surgical_history' => 'bail|sometimes|string|nullable',
            'medicine_history' => 'bail|sometimes|string|nullable',
            'allergies_history' => 'bail|sometimes|string|nullable',
            'family_history' => 'bail|sometimes|string|nullable',
            'social_history' => 'bail|sometimes|string|nullable',
            'consultant_id' => ['bail','sometimes','nullable',Rule::exists('users', 'id')],
            'chief_complaint_relation_id' => 'bail|sometimes|nullable:exists:relations,id'
        ];
    }
}
