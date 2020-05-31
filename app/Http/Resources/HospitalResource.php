<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
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
        $country=$this->country??null;
        $region=$this->region??null;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'nhis_provider_level_id' => $this->nhis_provider_level_id??null,
            'nhis_provider_level_name' => $this->nhis_provider_level->name??null,
            'ownership_type'=>$this->ownership_type,
            'nhis_authorization_code'=>$this->nhis_authorization_code,
            'nhis_provider_no'=>$this->nhis_provider_no,
            'nhis_claim_submission_mode'=>$this->nhis_claim_submission_mode,
            'claim_manager_name'=>$this->claim_manager_name,
            'claim_manager_signature' => $this->claim_manager_signature ? \route('file.url', ['users-signatures', $this->claim_manager_signature]) : null,
            'staff_id_prefix'=>$this->staff_id_prefix,
            'staff_id_seperator'=>$this->staff_id_seperator,
            'folder_id_prefix'=>$this->folder_id_prefix,
            'folder_id_seperator'=>$this->folder_id_seperator,
            'digits_after_staff_prefix'=>$this->digits_after_staff_prefix,
            'digits_after_folder_prefix'=>$this->digits_after_folder_prefix,
            'walkin_prefix'=>$this->walkin_prefix??null,
            'walkin_id_type'=>$this->walkin_id_type??null,
            'year_digits'=>$this->year_digits,
            'allowed_folder_type'=>$this->allowed_folder_type,
            'allowed_installment_type'=>$this->allowed_installment_type,
            'active_cell'=>$this->active_cell??null,
            'alternate_cell'=>$this->alternate_cell??null,
            'email1'=>$this->email1,
            'email2'=>$this->email2,
            'postal_address'=>$this->postal_address,
            'physical_address'=>$this->physical_address,
            'country_name'=>$country->country_name??null,
            'country_id'=>$country->id??null,
            'region_name'=>$region->region_name??null,
            'region_id'=>$region->id??null,
            'gps_location'=>$this->gps_location,
            'ownership_type'=>$this->ownership_type,
            'logo'=>$this->logo?\route('file.url',['logos',$this->logo]):null,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
