<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class StoreActivityRequest extends ApiFormRequest
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
        $id=$this->route('storeactivity')??null;
        return [
            'store_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:stores,id|'.$this->softUnique('storeactivities','store_id',$id),
            'purchasing_from_suppliers'=>'bail|sometimes|boolean',
            'receiving_from_suppliers'=>'bail|sometimes|boolean',
            'issuing_requested_product'=>'bail|sometimes|boolean',
            'requesting_products_from_stores'=>'bail|sometimes|boolean',
            'receiving_issued_products'=>'bail|sometimes|boolean',
            'direct_engagement_with_patient'=>'bail|sometimes|boolean'
        ];
    }
}
