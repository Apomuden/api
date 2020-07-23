<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class BankRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('bank') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('banks', 'name', $id),
            'priority' => 'bail|sometimes|integer|gt:-1',
            'sort_code' => 'bail|sometimes|' . $this->softUnique('banks', 'sort_code', $id),
            'email' => 'bail|sometimes|email',
            'phone' => 'bail|sometimes|numeric',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
