<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class SpecialtyRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('specialty')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:staff_specialties'.($id?','.$id:''),

            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
