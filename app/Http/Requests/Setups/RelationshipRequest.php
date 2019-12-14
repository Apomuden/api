<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class RelationshipRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('relationship')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique_with:relationships,district_id'.(isset($this->id)?','.$this->id:''),

            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
