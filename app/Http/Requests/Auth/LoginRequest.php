<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class LoginRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'username' => 'bail|required|max:255',
            'password' => 'bail|required|max:255',
        ];
    }
}
