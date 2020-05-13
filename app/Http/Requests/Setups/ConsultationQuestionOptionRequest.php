<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class ConsultationQuestionOptionRequest extends ApiFormRequest
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
        $id = $this->route('option');
        return [
            'consultation_question_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:consultation_questions,id|'
                . $this->softUniqueWith('consultation_question_options', 'value,consultation_question_id,gender', $id),

            'value' => 'bail|' . ($id ? 'sometimes' : 'required'),
            'status' => 'bail|string|in:ACTIVE,INACTIVE'
        ];
    }
}
