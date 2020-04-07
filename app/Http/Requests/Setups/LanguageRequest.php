<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class LanguageRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('language')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|'.$this->softUnique('languages','name',$id),

            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
