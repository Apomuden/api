<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class AttachModulesToRoleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){

        return [
            //'role_id' => 'bail|required|integer|exists:roles,id',
            'module_ids'=>'bail|required|array',
            'module_ids.*'=>'bail|exists:modules,id'
        ];
   }
}
