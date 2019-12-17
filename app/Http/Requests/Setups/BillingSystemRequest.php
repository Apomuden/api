<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class BillingSystemRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('billingsystem')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:billing_systems'.($id?','.$id:''),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
