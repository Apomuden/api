<?php

namespace App\Http\Requests\Setups;

use App\Http\Requests\ApiFormRequest;
use App\Models\Hospital;
use App\Models\NhisAccreditationSetting;
use App\Repositories\HospitalEloquent;
use App\Repositories\NhisAccreditationSettingEloquent;
use Illuminate\Validation\Rule;

class NhisAccreditationSettingRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $nhisAccreditationRepo = new NhisAccreditationSettingEloquent(new NhisAccreditationSetting);
        $id = $nhisAccreditationRepo->first()->id ?? null;
        return [
            'nhis_provider_level_id' => ['bail', 'sometimes', 'nullable', Rule::exists('nhis_provider_levels', 'id')->whereNull('deleted_at')],
            'nhis_authorization_code' => 'bail|nullable|sometimes',
            'tariff_type' => 'bail|nullable|sometimes|in:CAPITATION,GDRG',
            'nhis_provider_no' => 'bail|nullable|sometimes',
            'nhis_claim_submission_mode' => 'bail|nullable|sometimes|in:PRINTING,ELECTRONIC',
            'claim_manager_name' => 'bail|nullable|sometimes|string',
            'claim_manager_signature' => 'bail|nullable|sometimes|file64:jpeg,jpg,png'
        ];
    }

    public function validationData()
    {
        $data = parent::validationData();
        unset($data['deleted_at']);
        return $data;
    }
}
