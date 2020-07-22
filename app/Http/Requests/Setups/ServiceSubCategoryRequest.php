<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;

class ServiceSubCategoryRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('servicesubcategory') ?? null;
        return [
            'name' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|' . $this->softUniqueWith('service_subcategories', 'service_category_id', $id),
            'service_category_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|exists:service_categories,id',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
