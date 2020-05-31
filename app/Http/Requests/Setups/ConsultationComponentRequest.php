<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class ConsultationComponentRequest extends ApiFormRequest
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
        $id = $this->route('consultationcomponent');
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required'),
            'status' => 'bail|string|in:ACTIVE,INACTIVE'
        ];
    }
}
