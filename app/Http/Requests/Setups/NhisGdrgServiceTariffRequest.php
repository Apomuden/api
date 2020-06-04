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
            'gdrg_code' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_code',$id),
            'gdrg_service_name'=>'bail|'. ($id ? 'sometimes' : 'required').'|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_service_name',$id),
            'nhis_provider_level_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exists:nhis_provider_levels,id',
            'major_diagnostic_category_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exists:major_diagnostic_categories,id',
            'tariff'=>'bail|sometimes|numeric|min:0',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
