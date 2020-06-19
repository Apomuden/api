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
        return [
            'week_number' => 'bail|required|numeric|min:1',
        ];
    }
}
