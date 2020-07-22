<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class EducationalLevelRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('educationallevel') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('educational_levels', 'name', $id),
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
