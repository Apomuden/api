<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class SponsorshipPolicyRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('sponsorpolicy')??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUniqueWith('sponsorship_policies', 'name,billing_sponsor_id',$id),
            'billing_sponsor_id'=>'bail|'. ($id ? 'sometimes' : 'required').'|exists:billing_sponsors,id',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
