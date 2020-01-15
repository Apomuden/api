<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class DistrictRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
    $id = $this->route('district')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUniqueWith('districts','region_id',$id),
            //'country_id' => 'bail|'.($id?'sometimes':'required').'|numeric',
            'region_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
