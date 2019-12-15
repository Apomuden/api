<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class BankRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('bank')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:departments,district_id'.(isset($this->id)?','.$this->id:''),
            'sort_code'=>'bail|sometimes',
            'email'=>'bail|sometimes|email',
            'phone'=>'bail|sometimes|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
