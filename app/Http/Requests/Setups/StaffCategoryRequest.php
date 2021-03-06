<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Log;

class StaffCategoryRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $id=$this->route('staffcategory')??null;

        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|string|unique:staff_categories'.($id?','.$id:''),

            'status'=>'bail|sometimes|in:ACTIVE,INACTIVE'
        ];
   }
}
