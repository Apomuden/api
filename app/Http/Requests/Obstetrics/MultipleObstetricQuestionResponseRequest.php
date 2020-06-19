<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

/**
 * @property mixed responses
 * @property mixed consultation_id
 */
class MultipleObstetricQuestionResponseRequest extends ApiFormRequest
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
        if (sizeof($this->request->get("responses")) == 0)
            return [];
        return [
            'consultation_id' => 'bail|required|exists:consultations,id',
            'patient_id' => 'bail|required|exists:patients,id',
            'responses' => 'bail|required|array',
            'responses.*.obstetric_question_id' => ['bail', 'required', 'distinct', 'exists:obstetric_questions,id'],
            'responses.*.response' => 'bail|sometimes',
            'response_date' => 'bail|required|date',
        ];
    }
}
