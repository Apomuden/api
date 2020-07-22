<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class ProfileNextOfKinRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('profilenextofkin') ?? null;

        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('staff_next_of_kin', 'phone,user_id', $id),
            'phone' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|min:10',
            'email' => 'bail|sometimes|nullable|email',
            'user_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:users,id',
            'relation_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:relationships,id',
            'address' => 'bail|sometimes|nullable',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
