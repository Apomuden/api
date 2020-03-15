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
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('age_groups','name',$id),
            //'duration_type'=>'bail|sometimes|in:YEAR,MONTH',
            'min_age'=>'bail|'.($id?'sometimes':'required').'|min:0,max:100',
            'max_age'=>'bail|sometimes|nullable|min:1',
            'max_age_unit'=>'bail|sometimes|nullable|in:YEAR,MONTH,WEEK,DAY',
            'min_age_unit'=>'bail|sometimes|in:YEAR,MONTH,WEEK,DAY',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
