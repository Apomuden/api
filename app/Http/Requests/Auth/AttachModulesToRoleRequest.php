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
            'modules'=>'bail|required|array',
            'modules.*.id'=> 'bail|distinct|exists:modules,id'
        ];
   }
}
