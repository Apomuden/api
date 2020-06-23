<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class ObstetricQuestionOptionRequest extends ApiFormRequest
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
        $id = $this->route('obstetric_question_options') ?? null;

        return [
            'obstetric_question_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:obstetric_questions,id',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE',
            'value' => 'bail|required',
        ];
    }
}
/*
 "obstetric_question_id" : 1,
            "value" : "Some value",
 */