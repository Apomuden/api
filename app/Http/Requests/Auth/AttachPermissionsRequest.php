<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ApiFormRequest;

class AttachPermissionsRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){

        return [
            //'role_id' => 'bail|required|integer|exists:roles,id',
            'permission_ids'=>'bail|required|array',
            'permission_ids.*'=>'bail|exists:permissions,id'
        ];
   }
}
