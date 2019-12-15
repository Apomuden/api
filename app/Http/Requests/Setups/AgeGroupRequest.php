<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class AgeGroupRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('agegroup')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:departments,district_id'.(isset($this->id)?','.$this->id:''),
            'duration_type'=>'bail|sometimes|in:YEAR,MONTH',
            'min_age'=>'bail|'.($id?'sometimes':'required').'|min:0,max:100',
            'max_age'=>'bail|'.($id?'sometimes':'required').'|min:1',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
