<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class MajorDiagnosticCategoryRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('majordiagnosticcategory')??null;
        return [
            'description' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUniqueWith('major_diagnostic_categories','description,gender,patient_status,age_group_id,hospital_service_id',$id),
            'mdc_code'=>'bail|'. ($id ? 'sometimes' : 'required').'|'.$this->softUnique('major_diagnostic_categories', 'mdc_code',$id),
            'hospital_service_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exists:hospital_services,id',
            'patient_status'=>'bail|'. ($id ? 'sometimes' : 'required'). '|set:OUT-PATIENT,IN-PATIENT',
            'gender'=>'bail|'. ($id ? 'sometimes' : 'required'). '|set:MALE,FEMALE,BIGENDER',
            'age_group_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exits:age_groups,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
