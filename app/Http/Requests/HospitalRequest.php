<?php

namespace App\Http\Requests;

class HospitalRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
        return [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ];
   }
}
