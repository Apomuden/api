<?php

namespace App\Http\Requests;

class HospitalRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
        return [
            'name' => 'bail|required|max:255',
            'logo' => 'bal|sometimes|image',
            'staff_id_prefix'=>'bail|required|max:5',
            'staff_id_seperator'=>'bail|required|max:1',
            'folder_id_prefix'=>'bail|bail|required|max:5',
            'folder_id_seperator'=>'bail|required|max:1',
            'folder_type'=>'bail|required|in:INDIVIDUAL,FAMILY',
            'consultation_type'=>'bail|required|in:INDIVIDUAL,FAMILY',
            'payment_style'=>'bail|required|in:PREPAID,POSTPAID',
            'discount_type'=>'bail|required|ABSOLUTE,PERCENTAGE',
            'discount'=>'bail|sometimes|numeric',
            'hours_of_consultation'=>'bail|sometimes|numeric',
            'payment_channels'=>'bail|sometimes|nullable|in:CASH,MOMO,POS,CHEQUE,BANK_DEPOSIT',
            'installment_type'=>'bail|sometimes|nullable|in:FULL_PAYMENT,PART_PAYMENT,DEPOSIT,CREDIT',
            'set_appointment'=>'bail|sometimes|boolean',
            'phone1'=>'bail|required|numeric',
            'phone2'=>'bail|sometimes|nullable|numeric',
            'email1'=>'bail|required|email',
            'email2'=>'bail|sometimes|nullable|email',
            'postal_address'=>'bail|sometimes|nullable|string',
            'gps_location'=>'bail|sometimes',
            'accreditation_id'=>'bail|numeric'
        ];
   }
}
