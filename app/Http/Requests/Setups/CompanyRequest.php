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
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('companies','name',$id),
            'phone' => 'bail|sometimes|numeric|min:10|'.$this->softUnique('companies','phone',$id),
            'email'=>'bail|sometimes|email|'. $this->softUnique('companies', 'email', $id),
            'sponsorship_type_id'=>'bail|sometimes|integer|exists:sponsorship_types,id',
            'gps_location'=>'bail|sometimes|string',
            'postal_address'=>'bail|sometimes|string',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
