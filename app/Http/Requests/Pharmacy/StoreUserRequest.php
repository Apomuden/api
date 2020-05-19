<?php

namespace App\Http\Requests\Pharmacy;

use App\Http\Requests\ApiFormRequest;

class StoreUserRequest extends ApiFormRequest
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
        $id=$this->route('storeuser')??null;
        return [
            'store_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:stores,id|'.$this->softUniqueWith('storeusers','store_id,user_id',$id),
            'user_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:stores,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
    }
}
