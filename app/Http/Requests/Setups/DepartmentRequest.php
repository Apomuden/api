<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class DepartmentRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('department')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:departments'.(isset($this->id)?','.$this->id:''),
            'head_id'=>'bail|sometimes|nullable|uuid',
            'deputy_head_id'=>'bail|sometimes|nullable|uuid',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
