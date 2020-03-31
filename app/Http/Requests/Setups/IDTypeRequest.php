<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class IDTypeRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('idtype')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('id_types','name',$id),
            'expires'=>'bail|sometimes|boolean',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
