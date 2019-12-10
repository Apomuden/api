<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;

class HospitalUpdateRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
        return [
            'name' => 'bail|sometimes|max:255',
            'logo' => 'bail|sometimes|file64:jpeg,jpg,png',
            'staff_id_prefix'=>'bail|sometimes|max:5',
            'staff_id_seperator'=>'bail|sometimes|max:1',
            'folder_id_prefix'=>'bail|bail|sometimes|max:5',
            'folder_id_seperator'=>'bail|sometimes|max:1',
            'folder_type'=>'bail|sometimes|in:INDIVIDUAL,FAMILY',
            'consultation_type'=>'bail|sometimes|in:INDIVIDUAL,FAMILY',
            'payment_style'=>'bail|sometimes|in:PREPAID,POSTPAID',
            'discount_type'=>'bail|sometimes|ABSOLUTE,PERCENTAGE',
            'discount'=>'bail|sometimes|numeric',
            'hours_of_consultation'=>'bail|sometimes|numeric',
            'payment_channels'=>'bail|sometimes|nullable|in:CASH,MOMO,POS,CHEQUE,BANK_DEPOSIT',
            'installment_type'=>'bail|sometimes|nullable|in:FULL_PAYMENT,PART_PAYMENT,DEPOSIT,CREDIT',
            'set_appointment'=>'bail|sometimes|boolean',
            'phone1'=>'bail|sometimes|numeric',
            'phone2'=>'bail|sometimes|nullable|numeric',
            'email1'=>'bail|sometimes|email',
            'email2'=>'bail|sometimes|nullable|email',
            'postal_address'=>'bail|sometimes|nullable|string',
            'gps_location'=>'bail|sometimes|string',
            'accreditation_id'=>'bail|sometimes|numeric'
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
