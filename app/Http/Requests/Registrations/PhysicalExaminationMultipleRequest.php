<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

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
            'exams.*.category_id'=> 'bail|distinct|exists:physical_examination_categories,id|'.$this->softUniqueWith('physical_examinations', 'category_id,consultation_id',null),
            'consultant_id' => ['bail', 'sometimes', 'nullable', Rule::exists('users', 'id')],
        ];
    }
}
