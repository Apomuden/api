<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserRemarkRequest extends ApiFormRequest
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
        $id = $this->route('remark') ?? null;
        return [
            'type' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:RECOMMENDATION,COMPLAINT,COMPLIMENT',
            'remarks' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'user_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|uuid|exists:users,id',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
