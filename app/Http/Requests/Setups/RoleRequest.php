<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class RoleRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('role')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:roles'.($id?','.$id:''),
            'description'=>'bail|sometimes|string',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
