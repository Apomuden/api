<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use App\Models\Country;
use DatePeriod;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ProfileWithIDResource extends JsonResource
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
        $title=$this->title;
        $id_type=$this->id_type;
        $role=$this->role;
        $religion=$this->religion;
        $educational_level=$this->educational_level;
        $staff_type=$this->staff_type;
        $staff_category=$this->staff_category;
        $staff_specialty=$this->staff_specialty;
        $bank=$this->bank;
        $bank_branch=$this->bank_branch;
        $emerg_relation=$this->emerg_relation;
        $hometown=$this->hometown;
        $profession=$this->profession;
        $department=$this->department;

        return [
            'id'=>$this->id,
            'title'=>$title->name,
            'title_id'=>$title->id??null,
            'staff_id'=>$this->staff_id,
            'ssnit_no'=>$this->ssnit_no,
            'tin'=>$this->tin,
            'username'=>$this->username,
            'surname'=>$this->surname,
            'middlename'=>$this->middlename,
            'firstname'=>$this->firstname,
            'dob'=>DateHelper::toDisplayDate($this->dob),
            'gender'=>$this->gender,
            'country_name'=>$country->country_name??null,
            'country_id'=>$country->id??null,
            'region_name'=>$region->region_name??null,
            'region_id'=>$region->id??null,
            'hometown_name'=>$hometown->name??null,
            'hometown_id'=>$hometown->id??null,
            'marital'=>$this->marital,
            'department_name'=>$department->name??null,
            'department_id'=>$department->id??null,
            'staff_category_name'=>$staff_category->name??null,
            'staff_category_id'=>$staff_category->id??null,
            'staff_type_name'=>$staff_type->name??null,
            'staff_type_id'=>$staff_type->id??null,
            'profession_name'=>$profession->name??null,
            'profession_id'=>$profession->id??null,
            'prof_body '=>$this->prof_body,
            'prof_reg_no '=>$this->prof_reg_no,
            'prof_expiry_date '=>DateHelper::toDisplayDate($this->prof_expiry_date)??null,
            'staff_specialty_name'=>$staff_specialty->name??null,
            'staff_specialty_id'=>$staff_specialty->id??null,
            'id_type_name'=>$id_type->name??null,
            'id_type_id'=>$id_type->id??null,
            'id_no'=>$this->id_no,
            'role_name'=>$role->name??null,
            'role_id'=>$role->id??null,
            'religion_name'=>$religion->name??null,
            'religion_id'=>$religion->id??null,
            'educational_level_name'=>$educational_level->name??null,
            'educational_level_id'=>$educational_level->id??null,
            'appointment_date'=>DateHelper::toDisplayDate($this->appointment_date)??null,
            'active_cell'=>$this->active_cell,
            'alternate_cell'=>$this->alternate_cell,
            'email'=>$this->email,
            'emerg_name'=>$this->emerg_name ,
            'emerg_phone1'=>$this->emerg_phone1 ,
            'emerg_phone2'=>$this->emerg_phone1 ,
            'emerg_relation_name'=>$emerg_relation->name??null,
            'emerg_relation_id'=>$emerg_relation->id??null,
            'bank_name'=>$bank->name??null,
            'bank_id'=>$bank->id??null,
            'bank_branch_name'=>$bank_branch->name??null,
            'bank_branch_id'=>$bank_branch->id??null,
            'expiry_date'=>DateHelper::toDisplayDate($this->expiry_date)??null,
            'photo'=>$this->photo?\route('file.url',['users-photos',$this->photo]):null,
            'signature'=>$this->signature?\route('file.url',['users-signatures',$this->signature]):null,
            'last_login'=>DateHelper::toDisplayDateTime($this->last_login),
            'last_logout '=>DateHelper::toDisplayDateTime($this->last_logout),
            'status'=>$this->status,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
