<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class DetachComponentsRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'components' => 'bail|required|array',
            'components.*.id' => 'bail|integer|distinct|exists:components,id'
        ];
    }
}
