<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class FundingTypeRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('fundingtype')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('funding_types','name',$id),
            'sponsorship_type_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'billing_system_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'billing_cycle_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'payment_style_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'payment_channel_id'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'description'=>'bail|sometimes|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
