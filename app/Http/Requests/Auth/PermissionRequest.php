<?php

namespace App\Http\Requests\Auth;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class PermissionRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('permission')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('permissions','name',$id),
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
