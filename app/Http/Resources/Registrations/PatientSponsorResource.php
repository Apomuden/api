<?php

namespace App\Http\Resources\Registrations;

use App\Http\Helpers\DateHelper;
use App\Models\SponsorshipType;
use Illuminate\Http\Resources\Json\JsonResource;

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
        if(isset($this->id)){
            $billing_sponsor = $this->billing_sponsor??null;
            $sponsorship_policy = $this->sponsorship_policy??null;
            $relationship = $this->relationship??null;
            $patient = $this->patient ?? null;
            $company=$this->company??null;
            //$user = $this->user;
            return [
                'id'=>$this->id,
                'patient_id'=>$patient->id??$this->patient_id??null,
                'billing_sponsor'=> [
                    'id'=>$billing_sponsor->id??null,
                    'name'=>$billing_sponsor->name??null,
                    'sponsorship_type_id'=>$billing_sponsor->sponsorship_type_id??null,
                    'sponsorship_type_name'=>$billing_sponsor->sponsorship_type_id? SponsorshipType::find($billing_sponsor->sponsorship_type_id)->name : null,
                ],
                'billing_sponsor_name' => $billing_sponsor->name??null,
                'billing_sponsor_id' => $billing_sponsor->id??null,
                'sponsorship_policy_name' => $sponsorship_policy->name??null,
                'sponsorship_policy_id' => $sponsorship_policy->id??null,
                'relation_name' => $relationship->name??null,
                'relation_id' => $relationship->id??null,
                'company_name'=>$company->name??null,
                'company_id'=>$company->id??null,
                'staff_name' => $this->staff_name,
                'staff_id' => $this->staff_id,
                'member_id'=>$this->member_id,
                'card_serial_no'=>$this->card_serial_no,
                'schema_code'=>$this->schema_code,
                'issued_date'=>DateHelper::toDisplayDateTime($this->issued_date),
                'expiry_date'=>DateHelper::toDisplayDateTime($this->expiry_date),
                'priority'=>$this->priority,
                'benefit_type'=>$this->benefit_type,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        else
            return NULL;
    }
}
