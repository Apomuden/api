<?php

namespace App\Http\Requests\Clinic;

use Illuminate\Foundation\Http\FormRequest;

class ClinicRequest extends FormRequest
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
        $id = $this->route('clinic') ?? null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:clinics'.($id?','.$id:''),
            'service_price_id'=>'bail|sometimes|integer|exists:service_prices,id',
            'hospital_service_id'=>'bail|sometimes|integer|exists:hospital_services,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
