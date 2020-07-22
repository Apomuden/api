<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

/**
 * @property mixed questions
 * @property mixed step
 */
class MultipleObstetricQuestionRequest extends ApiFormRequest
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
        if (sizeof($this->request->get("questions")) == 0) {
            return [];
        }
        return [
            'questions' => 'bail|required|array',
            'step' => 'bail|required|in:Infant Feeding,Menstrual History,Current Pregnancy',
            'questions.*.value_type' => 'bail|required|in:Text,Number,True/False,Select',
            'questions.*.question' => ['bail', 'required', 'distinct'],
            'questions.*.order' => 'bail|required|distinct|integer|min:1'
        ];
    }
}
