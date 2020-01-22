<?php

namespace App\Http\Requests\Clinic;

use App\Http\Requests\ApiFormRequest;
use App\Models\HospitalService;

class ClinicConsultServiceRequest extends ApiFormRequest
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
        $id = $this->route('consultationservice') ?? null;

        return [
            'display_name' => 'bail|sometimes|nullable|string|'.$this->softUnique('clinic_consult_services','display_name',$id),
            'clinic_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:clinics,id',
            'billing_cycle_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:billing_cycles,id',
            'service_category_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:service_categories,id',
            'duration'=>'bail|'.($id?'sometimes':'required').'|numeric|min:1',
            'price'=>'bail|'.($id?'sometimes':'required').'|numeric|min:0',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}
