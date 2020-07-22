<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class AccreditionRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('accreditation') ?? null;
        return [
            'reg_body' => 'bail|' . ($id ? 'sometimes' : 'required') . '|max:255|' . $this->softUniqueWith('accreditations', 'reg_no,reg_date', $id),
            'reg_no' => 'bail|' . ($id ? 'sometimes' : 'required') . '|max:255',
            'reg_date' => 'bail|' . ($id ? 'sometimes' : 'required') . '|date',
            'tin' => 'bail|' . ($id ? 'sometimes' : 'required') . '|max:255',
            'expiry_date' => 'bail|' . ($id ? 'sometimes' : 'required') . '|date',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
