<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class ProductCategoryRequest extends ApiFormRequest
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
        $id=$this->route('productcategories')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('product_categories','name',$id),
            'product_type_id'=>'bail|'.($id?'sometimes':'required').'|exists:product_types,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
