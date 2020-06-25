<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class DeliveryModeRequest extends ApiFormRequest
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
        $id = $this->route('delivery_modes') ?? null;
        return [
            'name' => 'bail|'. ($id ? 'sometimes' : 'required'),
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
