<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class NhisGdrgServiceCoverageRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('nhisgdrgservicecoverage') ?? null;
        return [
            'nhis_gdrg_service_tariff_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:nhis_gdrg_service_tariffs,id',
            'out_patient' => 'bail|sometimes|in:YES,NO',
            'in_patient' => 'bail|sometimes|in:YES,NO',
            'surgery' => 'bail|sometimes|in:YES,NO',
            'no_surgery' => 'bail|sometimes|in:YES,NO',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
