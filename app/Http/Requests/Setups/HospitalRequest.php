<?php

namespace App\Http\Requests\Setups;
use App\Http\Requests\ApiFormRequest;
use App\Models\Hospital;
use App\Repositories\HospitalEloquent;

class HospitalRequest extends ApiFormRequest
{
   public function authorize(){
       return true;
   }
   public function rules(){
       $hospitalRepo=new HospitalEloquent(new Hospital);
       $id=$hospitalRepo->first()->id??null;
        return [
            'name' => 'bail|'.($id?'sometimes':'required').'|max:255|unique:hospitals,name'.(isset($id)?','.$id:''),
            'logo' => 'bail|sometimes|nullable|file64:jpeg,jpg,png',
            'staff_id_prefix'=>'bail|sometimes|max:5',
            'staff_id_seperator'=>'bail|sometimes|max:1',
            'folder_id_prefix'=>'bail|bail|sometimes|max:5',
            'folder_id_seperator'=>'bail|sometimes|max:1',
            'digits_after_staff_prefix'=>'bail|sometimes|integer|between:2,9',
            'digits_after_folder_prefix'=>'bail|sometimes|integer|between:2,9',
            'year_digits'=>'bail|sometimes|integer|between:2,4',
            'allowed_folder_type'=>'bail|sometimes|set:INDIVIDUAL,FAMILY',
            'allowed_installment_type'=>'bail|sometimes|nullable|set:FULL_PAYMENT,PART_PAYMENT,DEPOSIT,CREDIT',
            'active_cell'=>'bail|'.($id?'sometimes':'required').'|numeric',
            'alternate_cell'=>'bail|sometimes|nullable|numeric',
            'email1'=>'bail|'.($id?'sometimes':'required').'|email',
            'email2'=>'bail|sometimes|nullable|email',
            'country_id'=>"bail|sometimes|nullable|exists:countries,id",
            'region_id'=>"bail|sometimes|nullable|exists:regions,id",
            'postal_address'=>'bail|sometimes|nullable|string',
            'gps_location'=>'bail|sometimes|nullable',
        ];


   }

    public function validationData()
    {
       $data=parent::validationData();
       unset($data['deleted_at']);
       return $data;
    }
}
