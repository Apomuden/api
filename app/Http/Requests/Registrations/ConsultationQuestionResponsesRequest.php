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
    private $id;

    public function authorize()
    {
        $this->id = $this->route('consultationquestionresponse');
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
            'consultation_id' => 'bail|' . ($this->id ? 'sometimes' : 'required') . '|exists:consultations,id',
            'responses' => 'bail|required|array',
            'responses.*.consultation_question_id' => ['bail', ($this->id ? 'sometimes' : 'required'), 'distinct', 'exists:consultation_questions,id'],
            'responses.*.response' => 'bail|' . ($this->id ? 'sometimes' : 'required'),
            'responses.*.response_date' => 'bail|date',
            'consultant_id' => ['bail', 'sometimes', 'nullable'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = parent::all();

            foreach ($all['responses'] as $response) {

                $response = (array)$response;
                if (!$this->id) {
                    $res = ConsultationQuestionResponse::where(['consultation_id' => $all['consultation_id'], 'consultation_question_id' => $response['consultation_question_id']])->first();

                    if (isset($res->response) && $res->response)
                        $validator->errors()->add("response", "{$res->consultation_question->question} has already been responded in this consultation");
                }

                if (isset($all['consultant_id']) && !in_array(User::find($all['consultant_id'])->role->name, ['Doctor', 'Physician', 'Dev']))
                    $validator->errors()->add("consultant_id", "the id provided is not of a consultant");
            }
        });
    }
}
