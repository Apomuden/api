<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class ProductsRequest extends ApiFormRequest
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
        $id = $this->route('product') ?? null;
        return [
            'brand_name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('products', 'brand_name,generic_name', $id),
            'generic_name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string',
            'product_type_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:product_types,id',
            'product_form_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:product_forms,id',
            'product_form_unit_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:product_form_units,id',
            'medicine_route_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:medicine_routes,id',
            'product_category_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:product_categories,id',
            'age_group_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:age_groups,id',
            'minimum_form_issue_unit' => 'bail|sometimes|nullable|string',
            'default_minimum_dosage' => 'bail|sometimes|nullable|string',
            'package_maximum_issue' => 'bail|sometimes|nullable|string',
            'strength_equivalent' => 'bail|sometimes|nullable|string',
            'gender' => 'bail|sometimes|in:MALE,FEMALE,BOTH',
            'nhis_cover' => 'bail|sometimes|in:YES,NO',
            'nhis_code' => 'bail|sometimes|nullable|string',
            'expires' => 'bail|sometimes|in:YES,NO',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
