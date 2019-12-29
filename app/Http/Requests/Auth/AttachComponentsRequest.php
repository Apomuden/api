<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ApiFormRequest;

class AttachComponentsRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
        return [
            'component_ids'=>'bail|required|array',
            'component_ids.*'=>'bail|exists:components,id'
        ];
   }
}
