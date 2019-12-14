<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class HospitalRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
        return [
            'name' => 'bail|required|max:255|unique:hospitals,name'.(isset($this->id)?','.$this->id:''),
            'logo' => 'bail|sometimes|file64:jpeg,jpg,png',
            'staff_id_prefix'=>'bail|sometimes|max:5',
            'staff_id_seperator'=>'bail|sometimes|max:1',
            'folder_id_prefix'=>'bail|bail|sometimes|max:5',
            'folder_id_seperator'=>'bail|sometimes|max:1',
            'digits_after_staff_prefix'=>'bail|sometimes|min:3',
            'digits_after_folder_prefix'=>'bail|sometimes|min:3',
            'year_digits'=>'bail|sometimes|min:2|max:4',
            'allowed_folder_type'=>'bail|required|in:INDIVIDUAL,FAMILY',
            'allowed_installment_type'=>'bail|sometimes|nullable|in:FULL_PAYMENT,PART_PAYMENT,DEPOSIT,CREDIT',
            'phone1'=>'bail|required|numeric',
            'phone2'=>'bail|sometimes|nullable|numeric',
            'email1'=>'bail|required|email',
            'email2'=>'bail|sometimes|nullable|email',
            'postal_address'=>'bail|sometimes|nullable|string',
            'gps_location'=>'bail|sometimes',
        ];
   }

   /* public function withValidator($validator)
   {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
   } */
}
