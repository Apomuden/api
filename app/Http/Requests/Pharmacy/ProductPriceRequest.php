<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductPriceRequest extends ApiFormRequest
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
        $id=$this->route('productprice');
        return [
            'product_id'=>'bail|'.($id?'sometimes':'required').'|'.$this->softExists('products','id'),
            'current_unit_cost'=> 'bail|' . ($id ? 'sometimes' : 'required').'|numeric|min:0',
            'previous_unit_cost'=> 'bail|sometimes|numeric|min:0',
            'prepaid_amount'=> 'bail|'. ($id ? 'sometimes' : 'required').'|numeric|min:0',
            'postpaid_amount'=> 'bail|'. ($id ? 'sometimes' : 'required').'|numeric|min:0',
            'nhis_amount'=> 'bail|'. ($id ? 'sometimes' : 'required').'|numeric|min:0',
        ];
    }
}
