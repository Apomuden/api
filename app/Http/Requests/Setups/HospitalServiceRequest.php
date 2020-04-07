<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class HospitalServiceRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('hospitalservice')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('hospital_services','name',$id),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
