<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class NhisGdrgServiceTariffMultipleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('nhisgdrgservicetariff')??null;
        return [
            'gdrg_code' => 'bail|'.($id?'sometimes':'required'). '|string|distinct|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_code',$id),
            'gdrg_service_name'=>'bail|'. ($id ? 'sometimes' : 'required'). '|distinct|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_service_name',$id),
            'major_diagnostic_category_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|'.$this->softExists('major_diagnostic_categories', 'id'),
            'age_group_id'=>'bail|required|exists:age_groups,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE',
            'nhis_provider_levels'=> 'bail|required|array',
            'nhis_provider_levels.*.nhis_provider_level_id' => 'bail|' . ($id ? 'sometimes' : 'required') .'|'.$this->softExists('nhis_provider_levels','id'),
            'nhis_provider_levels.*.tariff' => 'bail|sometimes|numeric|min:0',

        ];
   }
}
