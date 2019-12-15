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
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:departments,district_id'.(isset($this->id)?','.$this->id:''),

            'head_id'=>'bail|sometimes|uuid',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
