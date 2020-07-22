<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use App\Models\Country;
use DatePeriod;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $country = $this->country;
        $region = $this->region;
        $district = $this->district;
        $title = $this->title;
        $id_type = $this->id_type;
        $religion = $this->religion;
        $educational_level = $this->educational_level;

        $emerg_relation = $this->emerg_relation;
        $hometown = $this->hometown;
        $profession = $this->profession;

        $folder = $this->activefolder;
        $old_folder_no = $this->oldfolder->folder_no ?? $this->old_folder_no;
        $sponsorship_type = $this->sponsorship_type;
        $funding_type = $this->funding_type;
        $billing_system = $this->billing_system;
        $billing_cycle = $this->billing_cycle;
        $payment_style = $this->payment_style;
        $payment_channel = $this->payment_channel;
        $native_language = $this->native_language;
        $second_language = $this->second_language;
        $official_language = $this->official_language;

        return [
            'id' => $this->id ?? null,
            'title' => $title->name ?? null,
            'title_id' => $title->id ?? null,
            'patient_no' => $this->patient_id ?? null,
            'folder_no' => (($folder->folder_no ?? null) . ($this->postfix ?? null)) ?? null,
            'folder_rack' => $folder->rack_no ?? null,
            'folder_type' => $folder->folder_type ?? null,
            'folder_status' => $folder->status ?? null,
            'old_folder_no' => $old_folder_no ?? null,
            'funding_type_name' => $funding_type->name ?? null,
            'funding_type_id' => $funding_type->id ?? null,
            'sponsorship_type_name' => $sponsorship_type->name ?? null,
            'sponsorship_type_id' => $sponsorship_type->id ?? null,
            'billing_system_name' => $billing_system->name ?? null,
            'billing_system_id' => $billing_system->id ?? null,
            'billing_cycle_name' => $billing_cycle->name ?? null,
            'billing_cycle_id' => $billing_cycle->id ?? null,
            'payment_style_name' => $payment_style->name ?? null,
            'payment_style_id' => $payment_style->id ?? null,
            'payment_channel_name' => $payment_channel->name ?? null,
            'payment_channel_id' => $payment_channel->id ?? null,
            'ssnit_no' => $this->ssnit_no,
            'tin' => $this->tin,
            'username' => $this->username,
            'surname' => $this->surname,
            'middlename' => $this->middlename,
            'firstname' => $this->firstname,
            'dob' => DateHelper::toDisplayDate($this->dob),
            'gender' => $this->gender,
            'country_name' => $country->country_name ?? null,
            'country_id' => $country->id ?? null,
            'region_name' => $region->region_name ?? null,
            'region_id' => $region->id ?? null,
            'district_name' => $district->name ?? null,
            'district_id' => $district->id ?? null,
            'hometown_name' => $hometown->name ?? null,
            'hometown_id' => $hometown->id ?? null,
            'marital' => $this->marital,
            'profession_name' => $profession->name ?? null,
            'profession_id' => $profession->id ?? null,
            'staff_id' => $this->staff_id ?? null,
            'work_address' => $this->work_address ?? null,
            'residence_address' => $this->residence_address ?? null,

            'native_language_name' => $native_language->name ?? null,
            'native_language_id' => $native_language->id ?? null,
            'second_language_name' => $second_language->name ?? null,
            'second_language_id' => $second_language->id ?? null,
            'official_language_name' => $official_language->name ?? null,
            'official_language_id' => $official_language->id ?? null,

            'id_type_name' => $id_type->name ?? null,
            'id_type_id' => $id_type->id ?? null,
            'id_no' => $this->id_no,
            'id_expiry_date' => DateHelper::toDisplayDate($this->id_expiry_date) ?? null,

            'religion_name' => $religion->name ?? null,
            'religion_id' => $religion->id ?? null,
            'educational_level_name' => $educational_level->name ?? null,
            'educational_level_id' => $educational_level->id ?? null,
            'active_cell' => $this->active_cell,
            'email' => $this->email,
            'emerg_name' => $this->emerg_name ,
            'emerg_phone' => $this->emerg_phone1 ,
            'emerg_relation_name' => $emerg_relation->name ?? null,
            'emerg_relation_id' => $emerg_relation->id ?? null,

            'photo' => $this->photo ? \route('file.url', ['patients-photos',$this->photo]) : null,
            'mortality' => $this->mortality,
            'reg_status' => $this->reg_status,
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
