<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class ProductTypeRequest extends ApiFormRequest
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
        $id = $this->route('producttype') ?? null;

        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('product_types', 'name', $id),
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
