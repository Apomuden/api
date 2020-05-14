<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class ConsultationQuestionRequest extends ApiFormRequest
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
        $id = $this->route('consultationquestion');
        return [
            'question' => 'bail|' . ($id ? 'sometimes' : 'required')
                . '|string|' . $this->softUnique('consultation_questions', 'question', $id),
            'value_type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:Text,Number,True/False/Select',
            'gender' => 'bail|' . ($id ? 'sometimes' : 'required') . '|set:MALE,FEMALE',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
