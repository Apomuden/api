<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use App\Models\NhisGdrgServiceTariff;
use Illuminate\Validation\Rule;

class NhisTariffMappingRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('nhistariffmapping')??null;
        return [
            'services' => 'bail|required|array',
            'services.*.id' => 'bail|'.($id?'sometimes':'required'). '|int|distinct|exists:services,id',
            'services.*.nhis_child_tariff_id'=>['bail','nullable', Rule::exists('nhis_gdrg_service_tariffs', 'id')->whereNull('deleted_at')->whereNot('tariff_type', 'ADULT')],
            'services.*.nhis_adult_tariff_id'=> ['bail','nullable', Rule::exists('nhis_gdrg_service_tariffs', 'id')->whereNull('deleted_at')->whereNot('tariff_type', 'CHILD')]
        ];
   }
    /* public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $all = $this->all();

            $errorCounter=0;
            if(isset($all['services'])){
                foreach($all['services'] as $service){
                    $service=(array) $service;
                    // if($service['nhis_child_tariff_id']==$service['nhis_adult_tariff_id'])
                    //     $validator->errors()->add("nhis_child_tariff_id", "Selected services.$errorCounter.nhis_child_tariff_id cannot be the equal to services.$errorCounter.nhis_adult_tariff_id!");
                    // else{
                        $child_tariff=NhisGdrgServiceTariff::find($service['nhis_child_tariff_id']);
                        $adult_tariff=NhisGdrgServiceTariff::find($service['nhis_adult_tariff_id']);

                        if($child_tariff && $child_tariff->tariff_type=='ADULT')
                        $validator->errors()->add("nhis_child_tariff_id", "Selected services.$errorCounter.nhis_child_tariff_id is not for children!");
                        else if($adult_tariff && $adult_tariff->tariff_type=='CHILD')
                        $validator->errors()->add("nhis_adult_tariff_id", "Selected services.$errorCounter.nhis_adult_tariff_id is not for adults!");

                    //}
                    $errorCounter++;
                }
            }

        });
    } */

    // public function all($keys = null)
    // {
    //     $data = parent::all($keys);
    //     return $data;
    // }
}
