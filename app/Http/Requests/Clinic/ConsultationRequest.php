<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;

class ConsultationRequest extends ApiFormRequest
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
        $id = $this->route('consultation') ?? null;
        return [
            'user_id'=>'bail|sometimes|integer|exists:users,id',
            'clinic_id'=>'bail|'.($id ? 'sometimes' : 'required').'|integer|exists:clinics,id',
            'patient_id'=>'bail|'.($id ? 'sometimes' : 'required').'|integer|exists:patients,id',
            'service_price_id'=>'bail|sometimes|integer|exists:service_prices,id',
            'scheduled_for' => 'bail|sometimes|date',
            'started_at' => 'bail|sometimes|date',
            'ended_at' => 'bail|sometimes|date',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
