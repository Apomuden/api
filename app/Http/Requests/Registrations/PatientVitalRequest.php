<?php

namespace App\Http\Requests\Registrations;

use App\Http\Helpers\Security;
use App\Http\Requests\ApiFormRequest;
use App\Models\Consultation;
use App\Models\Ereceipt;
use App\Models\Patient;
use App\Models\ServiceOrder;
use App\Models\ServiceRule;
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

            $rule = ServiceRule::whereName('Enforce Consultation Payment Before Vitals')->first();

            $patient=Patient::find(request('patient_id'));

            if($rule && $patient && in_array($patient->patient_status,explode(',',$rule->patient_status))){
                $paidConsultation = $patient->ereceipts()
                    ->whereHas('service_order', function ($q1) {
                        $q1->where('service_orders.status', 'FULL-PAYMENT')
                            ->whereDate('service_orders.attendance_date', Carbon::parse(request('attendance_date')))
                            ->whereHas('hospital_service', function ($q2) {
                                $q2->where('hospital_services.name', 'consultation');
                            });
                    })->count();

                   if(!$paidConsultation)
                     $validator->errors()->add('patient_id', 'Oops patient must pay for a consultation service before vitals!');
            }
        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);

        return $data;
    }
}
