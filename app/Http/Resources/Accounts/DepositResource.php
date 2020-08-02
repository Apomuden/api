<?php

namespace App\Http\Resources\Accounts;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
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
        $payment_channel = $this->payment_channel;
        return [
            'id' => $this->id,
            'patient_id' => $patient->id ?? null,
            'patient_status' => $this->patient_status ?? null,
            'patient_name' => $patient->fullname ?? null,
            'funding_type_id' => $funding_type->id ?? null,
            'funding_type_name' => $funding_type->name ?? null,
            'sponsorship_type_id' => $sponsorship_type->id ?? null,
            'sponsorship_type_name' => $sponsorship_type->name ?? null,
            'billing_sponsor_id' => $billing_sponsor->id ?? null,
            'billing_sponsor_name' => $billing_sponsor->name ?? null,
            'patient_sponsor_id' => $patient_sponsor->id ?? null,
            'patient_sponsor_name' => $patient_sponsor->name ?? null,
            'receipt_number' => $this->receipt_number ?? null,
            'payment_channel_id' => $payment_channel->id ?? null,
            'payment_channel_name' => $payment_channel->name ?? null,
            'payee_transaction_id' => $this->payee_transaction_id ?? null,
            'payee_account_no' => $this->payee_account_no ?? null,
            'api_internal_ref' => $this->api_internal_ref ?? null,
            'cheque_no' => $this->cheque_no ?? null,
            'bank_id' => $this->bank_id ?? null,
            'bank_name' => $this->bank->name ?? null,
            'deposit_amount' => $this->deposit_amount ?? null,
            'reason' => $this->reason ?? null,
            'status' => $this->status ?? null,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
