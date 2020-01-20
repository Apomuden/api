<?php

namespace App\Http\Requests\Clinic;

use App\Models\HospitalService;
use Illuminate\Foundation\Http\FormRequest;

class ClinicAttributeRequest extends FormRequest
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
    public function rules() : array
    {
        //$id = $this->route('clinicattributes') ?? $this->route('clinics') ?? null;
        $consultation_id = HospitalService::whereIn('name',['CONSULTATION','CONSULTATION SERVICE','CONSULTATION SERVICES'])->pluck('id')->first();

        return [
            'service_category_id'=>'bail|sometimes|integer|exists:service_categories,id,hospital_service_id,'.$consultation_id,
            'clinic_id'=>'bail|required|integer|exists:clinics,id',
            'billing_cycle_id'=>'bail|sometimes|integer|exists:billing_cycles,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
        ];
    }
}
