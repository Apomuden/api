<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class PaymentStyleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('paymentstyle')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:payment_styles'.($id?','.$id:''),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
