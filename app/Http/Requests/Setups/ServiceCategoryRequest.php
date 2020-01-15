<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class ServiceCategoryRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('servicecategory')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUniqueWith('service_categories','hospital_service_id',$id),
            'hospital_service_id'=>'bail|'.($id?'sometimes':'required').'|exists:hospital_services,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
