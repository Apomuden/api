<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class StaffTypeRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('stafftype')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:staff_types'.($id?','.$id:''),
            'validity_days'=>'bail|sometimes|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
