<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use App\Models\Service;

/**
 * @property array questions
 */
class ConsultationServiceQuestionsRequest extends ApiFormRequest
{

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
        return [
            'questions' => 'bail|required|array',
            'questions.*.id' => ['bail', 'required', 'distinct', 'exists:consultation_questions,id'],
            'questions.*.order' => 'bail|required|distinct|integer|min:1'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $clinic = Service::find(request('service_id'));

            if (is_null($clinic))
                $validator->errors()->add("Service id", "The id in path is not a Consultation service!");
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        $all = [];

        foreach ($data['questions'] as $question) {
            if ($this->method() == self::METHOD_DELETE)
                $all[$question['id']] = $question['id'];
            else
                $all[$question['id']] = ['order' => $question['order']];
        }
        $data['questions'] = $all;

        return $data;
    }
}
