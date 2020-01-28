<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use App\Models\Country;
use DatePeriod;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PatientSponsorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $billing_sponsor = $this->billing_sponsor ?? null;
        $sponsorship_policy=$this->sponsorship_policy??null;
        $patient = $this->patient ?? null;
        $relationship = $this->relationship??null;
        $company=$this->company;

      return [
            'id' => $this->id,
            'patient_id' => $patient->id,
            'billing_sponsor_name' => $billing_sponsor->name,
            'billing_sponsor_id' => $billing_sponsor->id,
            'sponsorship_policy_name' => $sponsorship_policy->name ?? null,
            'sponsorship_policy_id' => $sponsorship_policy->id ?? null,
            'member_id'=>$this->member_id,
            'card_serial_no'=>$this->card_serial_no??null,
            'company_name'=>$company->name??null,
            'company_id'=>$company->id??null,
            'staff_name'=>$this->staff_name??null,
            'staff_id'=>$this->staff_id??null,
            'benefit_type'=>$this->benefit_type??null,
            'relation_name' => $relationship->name ?? null,
            'relation_id' => $relationship->id ?? null,
            'status' => $this->status,
            'issued_date' => DateHelper::toDisplayDateTime($this->issued_date),
            'expiry_date' => DateHelper::toDisplayDateTime($this->expiry_date),
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
      ];
    }
}
