<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class NhisAccreditationSettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'nhis_provider_level_id' => $this->nhis_provider_level_id ?? null,
            'nhis_provider_level_name' => $this->nhis_provider_level->name ?? null,
            'nhis_authorization_code' => $this->nhis_authorization_code,
            'tariff_type' => $this->tariff_type ?? null,
            'nhis_provider_no' => $this->nhis_provider_no,
            'nhis_claim_submission_mode' => $this->nhis_claim_submission_mode,
            'claim_manager_name' => $this->claim_manager_name,
            'claim_manager_signature' => $this->claim_manager_signature ? \route('file.url', ['users-signatures', $this->claim_manager_signature]) : null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
