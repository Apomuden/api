<?php

namespace App\Http\Resources\Accounts;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AbscondResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $patient = $this->patient;
        $funding_type = $this->funding_type;
        $sponsorship_type = $this->sponsorship_type;
        $billing_sponsor = $this->billing_sponsor;
        $patient_sponsor = $this->patient_sponsor;
        return [
            'id'=>$this->id,
            'patient_id'=>$patient->id??null,
            'patient_status'=>$this->patient_status??null,
            'patient_name'=>$patient->fullname??null,
            'funding_type_id'=>$funding_type->id??null,
            'funding_type_name'=>$funding_type->name??null,
            'sponsorship_type_id'=>$sponsorship_type->id??null,
            'sponsorship_type_name'=>$sponsorship_type->name??null,
            'billing_sponsor_id'=>$billing_sponsor->id??null,
            'billing_sponsor_name'=>$billing_sponsor->name??null,
            'patient_sponsor_id'=>$patient_sponsor->id??null,
            'patient_sponsor_name'=>$patient_sponsor->name??null,
            'receipt_number'=>$this->receipt_number??null,
            'abscond_amount'=>$this->abscond_amount??null,
            'status'=>$this->status??null,
            'abscond_date'=>DateHelper::toDisplayDateTime($this->abscond_date),
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
