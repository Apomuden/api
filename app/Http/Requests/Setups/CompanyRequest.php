<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class CompanyRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('company') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('companies', 'name', $id),
            'phone' => 'bail|sometimes|nullable|numeric|min:10|' . $this->softUnique('companies', 'phone', $id),
            'email' => 'bail|sometimes|nullable|email|' . $this->softUnique('companies', 'email', $id),
            'sponsorship_type_id' => 'bail|sometimes|nullable|integer|exists:sponsorship_types,id',
            'gps_location' => 'bail|sometimes|nullable|string',
            'postal_address' => 'bail|sometimes|nullable|string',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
