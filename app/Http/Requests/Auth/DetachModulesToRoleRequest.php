<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class DetachModulesToRoleRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {

        return [
            'modules' => 'bail|required|array',
            'modules.*' => 'bail|distinct|exists:modules,id'
        ];
    }
}
