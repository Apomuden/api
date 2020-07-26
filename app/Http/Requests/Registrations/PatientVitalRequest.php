<?php

namespace App\Http\Requests\Registrations;

use App\Http\Helpers\Security;
use App\Http\Requests\ApiFormRequest;
use App\Models\Consultation;
use App\Models\ServiceOrder;
use Carbon\Carbon;

class PatientVitalRequest extends ApiFormRequest
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
        $id = $this->route('patientvital') ?? null;
        return [
            'patient_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:patients,id',
            'temperature' => 'bail|sometimes|nullable|numeric',
            'pulse' => 'bail|sometimes|nullable|numeric',
            'systolic_blood_pressure' => 'bail|sometimes|nullable|numeric',
            'diastolic_blood_pressure' => 'bail|sometimes|nullable|numeric',
            'respiration' => 'bail|sometimes|nullable|numeric',
            'weight' => 'bail|sometimes|nullable|numeric',
            'height' => 'bail|sometimes|nullable|numeric',
            'bmi' => 'bail|sometimes|nullable|numeric',
            'oxygen_saturation' => 'bail|sometimes|nullable|numeric',
            'fasting_blood_sugar' => 'bail|sometimes|nullable|numeric',
            'random_blood_sugar' => 'bail|sometimes|nullable|numeric',
            'comment' => 'bail|sometimes|nullable|string',
            'status' => 'bail|sometimes|in:IN-QUEUE,ACTIVE,INACTIVE',
            'attendance_date' => 'bail|sometimes|nullable|date',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $all = $this->all();

            //$rule = Security::getServiceRule('Enforce Consultation Payment Before Vitals');

            //$validator->errors()->add('bank_id', 'bank id is required!');


        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        return $data;
    }
}
