<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class PhysicalExaminationRequest extends ApiFormRequest
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
        $id = $this->route('physicalexamination') ?? null;
        return [
            "consultation_id" => 'bail|integer|' . ($id ? 'sometimes' : 'required') . '|exists:consultations,id',
            'patient_status' => 'bail|sometimes|in:IN-PATIENT,OUT-PATIENT',
            'consultation_date' => 'bail|sometimes|date',
            'note' => 'bail|string|sometimes|nullable',
            'category_id' => 'bail|exists:physical_examination_categories,id',
            'consultant_id' => ['bail', 'sometimes', 'nullable', Rule::exists('users', 'id')],
        ];
    }
}
