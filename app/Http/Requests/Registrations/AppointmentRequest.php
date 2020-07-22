<?php

namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends ApiFormRequest
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
        $id = $this->route('appointment') ?? null;
        $patient_id = (request()->input('patient_id')) ?? null;
        $enquirer_name = (request()->input('enquirer_name')) ?? null;
        $staff_specialty_id = (request()->input('staff_specialty_id')) ?? null;

        return [
            'patient_id' => 'bail|' . (($id || $enquirer_name) ? 'sometimes' : 'required') . '|exists:patients,id|' . $this->softUniqueWith('appointments', 'patient_id,enquirer_name,appointment_date', $id),
            'enquirer_name' => 'bail|' . (($id || $patient_id) ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('appointments', 'patient_id,enquirer_name,appointment_date', $id),
            'enquirer_email' => 'bail|sometimes|nullable|string',
            'enquirer_residence' => 'bail|sometimes|nullable|string',
            'enquirer_phone' => 'bail|sometimes|nullable|string',
            'doctor_id' => [
                'bail', ($id ? 'sometimes' : 'required'),
                Rule::exists('users', 'id')->where(function ($query) use ($staff_specialty_id) {
                    $query->where(['status' => 'ACTIVE','staff_specialty_id' => $staff_specialty_id]);
                })
            ],
            'staff_specialty_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:staff_specialties,id',
            'comment' => 'bail|sometimes|nullable|string',
            'clinic_id' => [
                //'bail', ($id ? 'sometimes' : 'required'),
                'bail','sometimes','nullable',
                Rule::exists('clinics', 'id')->where(function ($query) {
                    $query->where('status', 'ACTIVE');
                })
            ],
            'appointment_date' => 'bail|sometimes|nullable|date',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
