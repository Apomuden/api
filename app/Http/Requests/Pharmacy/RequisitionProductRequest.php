<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class RequisitionProductRequest extends ApiFormRequest
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
        $id = $this->route('dummyparam') ?? null; //TODO: Change the route param from dummyparam

        return [
            
        ];
    }
}
