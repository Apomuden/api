<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class BankBranchRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('bankbranch') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('bank_branches', 'bank_id', $id),
            'sort_code' => 'bail|sometimes|' . $this->softUnique('bank_branches', 'sort_code', $id),
            'email' => 'bail|sometimes|email',
            'phone' => 'bail|sometimes|numeric',
            'bank_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|numeric',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
