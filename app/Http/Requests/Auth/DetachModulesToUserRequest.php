<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class DetachModulesToUserRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){

        return [
            //'role_id' => 'bail|required|integer|exists:roles,id',
            'modules'=>'bail|required|array',
            'modules.*'=>'bail|integer|distinct|exists:modules,id'
        ];
   }
}
