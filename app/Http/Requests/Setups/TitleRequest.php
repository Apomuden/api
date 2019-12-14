<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class TitleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('title')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:titles'.($this->id?','.$this->id:''),
            'gender'=>'bail|sometimes|Set:MALE,FEMALE',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
  
}
