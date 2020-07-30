<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;
use App\Models\NhisMedicine;
use App\Models\ProductType;
use Illuminate\Validation\Rule;

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
            'generic_name_id' => 'bail|sometimes|nullable|exists:product_generic_names,id',
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
            'nhis_code' => ['bail','sometimes|nullable',$this->softExists('nhis_medicines','code')],
            'nhis_medicine_id'=>['bail', Rule::requiredIf(function () {
                return request('nhis_cover') != null;
            }),$this->softExists('nhis_medicines','id')],
            'expires' => 'bail|sometimes|in:YES,NO',
            'status' => 'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $productType=ProductType::whereId(request('product_type_id'))->whereName('medicine')->first('id');

            if(request('product_type_id') && !$productType && (request('nhis_medicine_id')))
            $validator->errors()->add('product_type_id', 'product type should be medicine,when nhis_medicine_id is passed!');

        });
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        //if(request('nhis_code') && !request('nhis_medicine_id'))
        //$data['nhis_medicine_id']=NhisMedicine::whereCode(request('nhis_code'))->first('id');
        if(request('nhis_medicine_id') && !request('nhis_code'))
        $data['nhis_code'] = NhisMedicine::whereId(request('nhis_medicine_id'))->first('code');
        if(request('nhis_code') || request('nhis_medicine_id'))
        $data['nhis_cover']='YES';
        return $data;
    }
}
