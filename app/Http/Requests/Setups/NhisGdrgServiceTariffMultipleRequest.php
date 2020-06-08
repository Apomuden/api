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
            'services' => 'bail|required|array',
            'services.*.gdrg_code' => 'bail|'.($id?'sometimes':'required'). '|string|distinct|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_code',$id),
            'services.*.gdrg_service_name'=>'bail|'. ($id ? 'sometimes' : 'required'). '|distinct|'.$this->softUnique('nhis_gdrg_service_tariffs', 'gdrg_service_name',$id),
            'services.*.nhis_provider_level_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exists:nhis_provider_levels,id',
            'services.*.major_diagnostic_category_id'=>'bail|'. ($id ? 'sometimes' : 'required'). '|exists:major_diagnostic_categories,id',
            'services.*.tariff'=>'bail|sometimes|numeric|min:0',
            'services.*.status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
