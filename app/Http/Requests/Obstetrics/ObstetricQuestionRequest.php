<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class ObstetricQuestionRequest extends ApiFormRequest
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
        $id = $this->route('obstetric_questions') ?? null;

        return [
            'order' => 'bail|'. ($id ? 'sometimes' : 'required'),
            'question' => 'bail|'. ($id ? 'sometimes' : 'required'),
            'status' => 'bail|'. ($id ? 'sometimes' : 'required'),
            'step' => 'bail|'. ($id ? 'sometimes' : 'required'),
            'value_type' => 'bail|'. ($id ? 'sometimes' : 'required'),
        ];
    }
}
