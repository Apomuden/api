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
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:departments,district_id'.(isset($this->id)?','.$this->id:''),
            'expires'=>'bail|sometimes|boolean',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
