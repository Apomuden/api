<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class ObstetricQuestionResponseRequest extends ApiFormRequest
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
        $id = $this->route('obstetric_question_responses') ?? null;

        return [
            'consultation_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:consultations,id',
            'obstetric_question_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:obstetric_questions,id',
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:patients,id',
            'response' => 'bail|sometimes',
            'response_date' => 'bail|required|date',
        ];
    }
}
