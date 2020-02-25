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
        $id=$this->route('appointment')??null;

        return [
            'patient_id'=>'bail|'.($id?'sometimes':'required').'|exists:patients,id',
            'doctor_id'=>'bail|'.($id?'sometimes':'required').'|exists:users,id',
            'comment'=>'bail|sometimes|nullable|string',
            'clinic_id'=> [
                'bail', ($id ? 'sometimes' : 'required'),
                Rule::exists('clinics', 'id')->where(function ($query) {
                    $query->where('status', 'ACTIVE');
                })
            ],
            'appointment_date'=>'bail|sometimes|nullable|date',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
