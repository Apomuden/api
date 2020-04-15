<?php

namespace App\Http\Requests\Lab;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class LabParameterRequest extends ApiFormRequest
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
        $id = $this->route('parameter') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('lab_parameters', 'name', $id),
            'value_type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:Text,Number',
            'unit' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
