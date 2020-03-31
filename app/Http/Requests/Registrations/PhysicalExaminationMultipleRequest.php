<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;
use App\Models\PhysicalExamination;

class PhysicalExaminationMultipleRequest extends ApiFormRequest
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
        return [
            "consultation_id" => 'bail|integer|required|exists:consultations,id',
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT',
            'consultation_date' => 'bail|sometimes|date',
            'exams' => 'bail|array',
            'exams.*.note'=>'bail|string|sometimes|nullable',
            'exams.*.category_id'=> 'bail|distinct|exists:physical_examination_categories,id',
            'consultant_id' => ['bail', 'sometimes', 'nullable', Rule::exists('users', 'id')],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();
            $errorCounter = 0;
            foreach ($all['exams'] as $exam) {
                $exam = (array) $exam;
                if (PhysicalExamination::where(['consultation_id' => $all['consultation_id'], 'category_id' => $exam['category_id']])->first())
                    $validator->errors()->add("exams.$errorCounter.category_id", "Physical examination note for exams.$errorCounter.category_id has already been submitted!");

                $errorCounter++;
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }
}
