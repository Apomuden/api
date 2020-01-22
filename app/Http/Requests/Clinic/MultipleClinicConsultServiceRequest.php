<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;

class MultipleClinicConsultServiceRequest extends ApiFormRequest
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
        return [
            'clinic_id' => 'bail|required|integer|exists:clinics,id',
            'consultation_services' => 'bail|required|array',
            'consultation_services.*.display_name' => 'bail|sometimes|nullable|string|',
            'consultation_services.*.billing_cycle_id'=>'bail|required|integer|exists:billing_cycles,id',
            'consultation_services.*.service_category_id'=>'bail|required|integer|exists:service_categories,id',
            'consultation_services.*.duration'=>'bail|required|numeric|min:1',
            'consultation_services.*.price'=>'bail|required|numeric|min:0',
            'consultation_services.*.status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}
