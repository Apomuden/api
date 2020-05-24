<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class NhisGdrgServiceTariffRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('nhisgdrgservicetariff')??null;
        return [
            'gdrg_code' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUniqueWith('nhis_gdrg_service_tariffs', 'gdrg_code',$id),
            'gdrg_service_name'=>'bail|'. ($id ? 'sometimes' : 'required').'|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_service_name',$id),
            'primary_with_catering'=>'bail|'. ($id ? 'sometimes' : 'required'). '|numeric|min:0',
            'primary_no_catering'=>'bail|'. ($id ? 'sometimes' : 'required'). '|numeric|min:0',
            'secondary_with_catering'=>'bail|'. ($id ? 'sometimes' : 'required'). '|numeric|min:0',
            'secondary_no_catering'=>'bail|'. ($id ? 'sometimes' : 'required'). '|numeric|min:0',
            'tertiary_with_catering'=>'bail|'. ($id ? 'sometimes' : 'required'). '|numeric|min:0',
            'tertiary_no_catering'=>'bail|'. ($id ? 'sometimes' : 'required'). '|numeric|min:0',
            'major_diagnostic_category_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exists:major_diagnostic_categories,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
