<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class PaymentChannelRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('paymentchannel')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:payment_channels'.($id?','.$id:''),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
