<?php

//This is Request is for the current logged in user
namespace App\Http\Requests\Registrations;

use App\Http\Requests\ApiFormRequest;
use App\Models\Hospital;
use App\Models\IdType;
use App\Repositories\HospitalEloquent;
use App\Repositories\RepositoryEloquent;

class PatientRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route('patient') ?? null;
        $id_type_id = \request()->input('id_type_id') ?? null;
        $reg_status = \request()->input('reg_status') ?? null;
        $id_type = null;
        if ($id_type_id) {
            $repository = new  RepositoryEloquent(new IdType());
            $id_type = $repository->find($id_type_id);
        }

        $data = [
            'title_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:titles,id',
            'old_folder_no' => 'bail|sometimes|nullable',
            'funding_type_id' => 'bail|' . ($id ? 'sometimes' : 'required') . '|integer|exists:funding_types,id',
            'folder_id' => 'bail|' . (($id || $reg_status == 'WALK-IN') ? 'sometimes' : 'required') . '|integer|exists:folders,id',
            'ssnit_no' => 'bail|sometimes|nullable',
            'tin' => 'bail|sometimes|nullable',
            'surname' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|min:2',
            'middlename' => 'bail|sometimes|nullable|string',
            'firstname' => 'bail|' . ($id ? 'sometimes' : 'required') . '|string|min:2',
            'dob' => 'bail|' . ($id ? 'sometimes' : 'required') . '|date',
            'gender' => 'bail|' . ($id ? 'sometimes' : 'required') . '|in:MALE,FEMALE,BIGENDER',
            'origin_country_id' => 'bail|sometimes|nullable|integer|exists:countries,id',
            'origin_region_id' => 'bail|sometimes|nullable|integer|exists:regions,id',
            'origin_district_id' => 'bail|sometimes|nullable|integer|exists:districts,id',
            'hometown_id' => 'bail|sometimes|nullable|integer|exists:towns,id',
            'marital' => 'bail|sometimes|nullable|in:SINGLE,MARRIED,DIVORCED,WIDOW,WIDOWER,OTHER',
            'profession_id' => 'bail|sometimes|nullable|integer|exists:professions,id',
            'staff_id' => 'bail|sometimes|nullable|string',
            'work_address' => 'bail|sometimes|nullable|string',
            'residence_address' => 'bail|sometimes|nullable|string',
            'native_language_id' => 'bail|sometimes|nullable|integer|exists:languages,id',
            'second_language_id' => 'bail|sometimes|nullable|integer|exists:languages,id',
            'official_language_id' => 'bail|sometimes|nullable|integer|exists:languages,id',
            'id_type_id' => 'bail|sometimes|nullable|integer|in:' . ($id_type->id ?? null),
            'id_no' => 'bail|' . ($id_type_id ? 'required' : 'sometimes|nullable') . '|' . $this->softUnique('patients', 'id_no', $id),
            'id_expiry_date' => 'bail|' . ($id_type_id && ($id_type && $id_type->expires) ? 'required' : 'sometimes|nullable') . '|date',
            'religion_id' => 'bail|sometimes|nullable|integer|exists:religions,id',
            'educational_level_id' => 'bail|sometimes|nullable|integer|exists:educational_levels,id',
            'active_cell' => 'bail|sometimes|nullable|integer|min:9',
            'email' => 'bail|sometimes|nullable|email',
            'emerg_name' => 'bail|sometimes|nullable|string|min:2',
            'emerg_phone' => 'bail|sometimes|nullable|integer|min:9',
            'emerg_relation_id' => 'bail|sometimes|nullable|integer|exists:relationships,id',
            'photo' => 'bail|sometimes|nullable|string|file64:jpeg,jpg,png',
            'mortality' => 'bail|sometimes|nullable|string|in:ALIVE,DEAD',
            'reg_status' => 'bail|sometimes|string|in:IN-PATIENT,OUT-PATIENT,WALK-IN',
            'status' => 'bail|sometimes|string|in:ACTIVE,INACTIVE,SUSPENDED,BLACKLISTED'
        ];
        return $data;
    }
}
