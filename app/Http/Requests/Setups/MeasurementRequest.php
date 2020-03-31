<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class MeasurementRequest extends ApiFormRequest
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
        $id = $this->route('measurement')??null;
        return [
            'name'=>'bail|'.($id?'sometimes':'required'),
            'unit'=>'bail|sometimes|string',
            'min_value'=>'bail|sometimes|nullable|numeric',
            'max_value'=>'bail|sometimes|nullable|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
