<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class BankBranchRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('bankbranch')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:departments,district_id'.(isset($this->id)?','.$this->id:''),
            'sort_code'=>'bail|sometimes',
            'email'=>'bail|sometimes|email',
            'phone'=>'bail|sometimes|numeric',
            'bank_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
