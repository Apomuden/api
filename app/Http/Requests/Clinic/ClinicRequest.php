<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;

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
        $consultation_id = HospitalService::whereIn('name',['CONSULTATION','CONSULTATION SERVICE','CONSULTATION SERVICES'])->pluck('id')->first();

        return [
            'name' => 'bail|'.($id ? 'sometimes':'required').'|string'.(!$id ? '|unique:clinics':''),
            'service_category_id'=>'bail|sometimes|integer|exists:service_categories,id,hospital_service_id,'.$consultation_id,
            'age'=>'bail|sometimes|in:ALL,CHILD,ADULT',
            'gender'=>'bail|sometimes|in:ALL,MALE,FEMALE',
            'patient_status'=>'bail|sometimes|in:ALL,OUT,IPD',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}
