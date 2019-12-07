<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class AccreditionRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
        return [
            'reg_body' => 'bail|required|max:255',
            'reg_no' => 'bail|required|max:255',
            'reg_date'=>'bail|required|date',
            'tin'=>'bail|required|max:255',
            'expiry_date'=>'bail|required|date',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
