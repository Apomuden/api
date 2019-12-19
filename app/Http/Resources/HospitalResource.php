<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $country=$this->country;
        $region=$this->region;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'staff_id_prefix'=>$this->staff_id_prefix,
            'staff_id_seperator'=>$this->staff_id_seperator,
            'folder_id_prefix'=>$this->folder_id_prefix,
            'folder_id_seperator'=>$this->folder_id_seperator,
            'digits_after_staff_prefix'=>$this->digits_after_staff_prefix,
            'digits_after_folder_prefix'=>$this->digits_after_folder_prefix,
            'year_digits'=>$this->digits_after_folder_prefix,
            'allowed_folder_type'=>$this->allowed_folder_type,
            'allowed_installment_type'=>$this->allowed_folder_type,
            'allowed_installment_type'=>$this->allowed_folder_type,
            'active_cell'=>$this->phone1,
            'alternate_cell'=>$this->phone2,
            'email1'=>$this->email1,
            'email2'=>$this->email2,
            'postal_address'=>$this->postal_address,
            'physical_address'=>$this->physical_address,
            'country_name'=>$country->country_name,
            'country_id'=>$country->id,
            'region_name'=>$region->region_name,
            'region_id'=>$region->id,
            'gps_location'=>$this->gps_location,
            'logo'=>$this->logo?\route('file.url',['logos',$this->logo]):null,
        ];
    }
}
