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
            'name' => 'bail|'.($id ? 'sometimes':'required').'|string'.(!$id ? '|unique:clinics':''),
            'service_price_id'=>'bail|sometimes|integer|exists:service_prices,id',
            'hospital_service_id'=>'bail|sometimes|integer|exists:hospital_services,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
