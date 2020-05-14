<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\ConsultationQuestionResponse;
use App\Models\User;

/**
 * @property mixed consultation_id
 * @property mixed consultation_question_id
 * @property mixed responses
 */
class ConsultationQuestionResponsesRequest extends ApiFormRequest
{
    private $isUpdate = false;

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
        $this->isUpdate = $this->method() == self::METHOD_PUT;
        return [
            // common rule
            'consultation_id' => 'bail|' . ($this->isUpdate ? 'sometimes' : 'required') . '|exists:consultations,id',

            // rule for single update
            'consultation_question_id' => 'bail|sometimes|exists:consultation_questions,id',
            'response_date' => 'bail|sometimes|date',

            // validation for bulk posting
            'responses' => 'bail|' . ($this->isUpdate ? 'sometimes' : 'required') . '|array',
            'responses.*.consultation_question_id' => ['bail', 'required', 'distinct', 'exists:consultation_questions,id'],
            'responses.*.response' => 'bail|required',
            'responses.*.response_date' => 'bail|date',
            'consultant_id' => 'bail|sometimes|nullable',
        ];
    }

    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            $data = parent::all();

            if (array_key_exists('consultant_id', $data) && isset($data['consultant_id'])) {
                $consultant = User::find($data['consultant_id']);
                if (isset($consultant) && !in_array($consultant->role->name, ['Doctor', 'Physician', 'Dev']))
                    $validator->errors()->add('consultant_id', 'the id provided is not of a consultant');
                else if (!isset($consultant))
                    $validator->errors()->add('consultant_id', 'the id provided is not valid');
            }
            // skip rest of validation cos single updates don't have responses field
            if ($this->isUpdate) return;

            if (!array_key_exists('responses', $data)) return;
            foreach ($data['responses'] as $response) {

                $response = (array)$response;
                $res = ConsultationQuestionResponse::where(['consultation_id' => $data['consultation_id'],
                    'consultation_question_id' => $response['consultation_question_id']])->first();

                if (isset($res->response) && $res->response)
                    $validator->errors()->add('response', "{$res->consultation_question->question} has already been responded in this consultation");
            }
        });
    }
}