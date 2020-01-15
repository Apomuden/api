<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ApiFormRequest;

class RoleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('role')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required'). "|string|".$this->softUnique('roles','name',$id),
            'description'=>'bail|sometimes|string',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
