<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class ProfessionRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('profession')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:professions'.($id?','.$id:''),
            'staff_category_id'=>'bail|sometimes|numeric',
            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
