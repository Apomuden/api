<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class TownRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('town')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUniqueWith('towns', 'district_id',$id),
            'district_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
