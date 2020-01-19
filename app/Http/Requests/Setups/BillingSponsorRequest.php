<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class BillingSponsorRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('billingsponsor')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('billing_sponsors','name',$id),
            'sponsorship_type_id'=>'bail|'.($id?'sometimes':'required'). '|integer|exists:sponsorship_types,id',
            'billing_system_id'=>'bail|'.($id?'sometimes':'required'). '|integer|exists:billing_systems,id',
            'billing_cycle_id'=>'bail|'.($id?'sometimes':'required'). '|integer|exists:billing_cycles,id',
            'payment_style_id'=>'bail|'.($id?'sometimes':'required'). '|integer|exists:payment_styles,id',
            'payment_channel_id'=>'bail|'.($id?'sometimes':'required'). '|integer|exists:payment_channels,id',
            'active_cell'=>'bail|'. ($id ? 'sometimes' : 'required').'|integer|min:9|'.$this->softUnique('billing_sponsors', 'active_cell',$id),
            'alternate_cell'=>'bail|sometimes|nullable|integer|min:9|'.$this->softUnique('billing_sponsors', 'alternate_cell',$id),
            'email1'=>'bail|sometimes|nullable|email|'.$this->softUnique('billing_sponsors','email1',$id),
            'email2'=>'bail|sometimes|nullable|email|'.$this->softUnique('billing_sponsors','email2',$id),
            'sponsor_code'=>'bail|'. ($id ? 'sometimes' : 'required').'|'.$this->softUnique('billing_sponsors','sponsor_code',$id),
            'address'=>'bail|sometimes|nullable',
            'website' => ['bail','sometimes','nullable',$this->websiteRegEx()],
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
