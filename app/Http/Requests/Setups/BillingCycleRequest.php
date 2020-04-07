<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class BillingCycleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('billingcycle')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('billing_cycles','name',$id),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
