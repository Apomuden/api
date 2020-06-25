<?php

namespace App\Http\Requests\Obstetrics;

use App\Http\Requests\ApiFormRequest;

class GestationalWeekRequest extends ApiFormRequest
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
        $id = $this->route('gestational_weeks') ?? null;
        return [
            'week_number' => 'bail|'. ($id ? 'sometimes' : 'required') . '|numeric|min:1',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
