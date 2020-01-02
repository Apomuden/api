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
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:billing_sponsors'.($this->id?','.$this->id:''),
            'sponsorship_type_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:sponsorship_types,id',
            'company_id'=>'bail|'.($id?'sometimes':'required').'|integer|exists:companies,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
