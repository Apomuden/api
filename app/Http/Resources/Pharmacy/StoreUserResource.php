<?php

namespace App\Http\Resources\Pharmacy;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $store = $this->store ?? null;
        $user = $this->user ?? null;
        return [
            'id' => $this->id,
            'store_name' => $store->name ?? null,
            'store_id' => $store->id ?? null,
            'user_id' => $this->user_id,
            'title' => $user->title->name ?? null,
            'title_id' => $user->title->id ?? null,
            'staff_id' => $user->staff_id ?? null,
            'ssnit_no' => $user->ssnit_no ?? null,
            'tin' => $user->tin ?? null,
            'username' => $user->username,
            'surname' => $user->surname,
            'middlename' => $user->middlename,
            'firstname' => $user->firstname,
            'dob' => DateHelper::toDisplayDate($user->dob),
            'gender' => $user->gender,
            'department_name' => $user->department->name ?? null,
            'department_id' => $user->department->id ?? null,
            'staff_category_name' => $user->staff_category->name ?? null,
            'staff_category_id' => $user->staff_category->id ?? null,
            'staff_type_name' => $user->staff_type->name ?? null,
            'staff_type_id' => $user->staff_type->id ?? null,
            'profession_name' => $user->profession->name ?? null,
            'profession_id' => $user->profession->id ?? null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at) ?? null,
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at) ?? null
        ];
    }
}
