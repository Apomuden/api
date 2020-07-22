<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class NhisProviderLevelRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('nhisproviderlevel') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('nhis_provider_levels', 'name', $id),
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
