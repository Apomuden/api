<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class ProductFormRequest extends ApiFormRequest
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
        $id=$this->route('productform')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('product_forms','name',$id),
            'product_category_id'=>'bail|'.($id?'sometimes':'required').'|exists:product_categories,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
