<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;

class ClinicRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        $id = $this->route('clinic') ?? null;

        return [
            //'' => 'bail|'.($id ? 'sometimes':'required').'|string'.(!$id ? '|unique:clinics':''),
            'service_price_id'=>'bail|sometimes|integer|exists:service_prices,id',
            'clinic_id'=>'bail|sometimes|integer|exists:clinics,id',
            'patient_id'=>'bail|sometimes|integer|exists:patients,id',
            'user_id'=>'bail|sometimes|integer|exists:users,id',
            'scheduled_for'=>'bail|sometimes|datetime|exists:users,id',
            'user_id'=>'bail|sometimes|integer|exists:users,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
