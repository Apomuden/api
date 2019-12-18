<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class CompanyRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
    $id = $this->route('company')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:companies'.($id?','.$id:''),
            'phone' => 'bail|sometimes|numeric|min:10|unique:companies'.($id?','.$id:''),
            'email'=>'bail|sometimes|email|unique:companies'.($id?','.$id:''),
            'gps_location'=>'bail|sometimes|string',
            'postal_address'=>'bail|sometimes|string',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
