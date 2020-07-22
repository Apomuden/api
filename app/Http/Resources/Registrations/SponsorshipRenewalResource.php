<?php

namespace App\Http\Resources\Registrations;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Helpers\DateHelper;

class SponsorshipRenewalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->id)) {
            $billing_sponsor = $this->billing_sponsor ?? null;
            $sponsorship_policy = $this->sponsorship_policy ?? null;
            $patient = $this->patient ?? null;
            $patient_sponsor = $this->patient_sponsor ?? null;

            return [
                'id' => $this->id,
                'patient_id' => $patient->id ?? $this->patient_id ?? null,
                'billing_sponsor_name' => $billing_sponsor->name ?? null,
                'billing_sponsor_id' => $billing_sponsor->id ?? null,
                'patient_sponsor_id' => $patient_sponsor->id ?? null,
                'sponsorship_policy_name' => $sponsorship_policy->name ?? null,
                'sponsorship_policy_id' => $sponsorship_policy->id ?? null,
                'member_id' => $this->member_id,
                'card_serial_no' => $this->card_serial_no,
                'renewal_start_date' => DateHelper::toDisplayDateTime($this->renewal_start_date),
                'renewal_end_date' => DateHelper::toDisplayDateTime($this->renewal_end_date),
                'renewed_by' => $this->renewed_by,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        return null;
    }
}
