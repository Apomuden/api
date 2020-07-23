<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class ProductFormUnitRequest extends ApiFormRequest
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
        $id = $this->route('productformunit') ?? null;

        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUnique('product_form_units', 'name', $id),
            'unit_type' => 'bail|sometimes|in:BASE,VOLUME',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
