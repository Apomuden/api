<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
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
            $sponsorship_type = $this->sponsorship_type;
            $billing_sponsor = $this->billing_sponsor;
            $sponsorship_policy = $this->sponsorship_policy;
            $relationship = $this->relationship;
            //$user = $this->user;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'sponsorship_type_name' => $sponsorship_type->name,
                'sponsorship_type_id' => $sponsorship_type->id,
                'billing_sponsor_name' => $billing_sponsor->name,
                'billing_sponsor_id' => $billing_sponsor->id,
                'sponsorship_policy_name' => $sponsorship_policy->name,
                'sponsorship_policy_id' => $sponsorship_policy->id,
                'relation_name' => $relationship->name,
                'relation_id' => $relationship->id,
                'staff_name' => $this->staff_name,
                'staff_id' => $this->staff_id,
                'member_id'=>$this->member_id,
                'card_serial_no'=>$this->card_serial_no,
                'issued_date'=>DateHelper::toDisplayDateTime($this->issued_date),
                'expiry_date'=>DateHelper::toDisplayDateTime($this->expiry_date),
                'patient_id'=>$this->patient_id,
                'priority'=>$this->priority,
                'benefit_type'=>$this->benefit_type,
                'sponsor_code'=>$this->sponsor_code,
                'user_id'=>$this->user_id,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        else
            return NULL;
    }
}
