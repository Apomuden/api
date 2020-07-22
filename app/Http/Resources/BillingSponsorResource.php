<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingSponsorResource extends JsonResource
{
    public function toArray($request)
    {
        if (isset($this->id)) {
            $sponsorship_type = $this->sponsorship_type;
            $billing_system = $this->billing_system;
            $billing_cycle = $this->billing_cycle;
            $payment_style = $this->payment_style;
            $payment_channel = $this->payment_channel;
            return [
                'id' => $this->id,
                'name' => $this->name,
                'sponsorship_type_name' => $sponsorship_type->name,
                'sponsorship_type_id' => $sponsorship_type->id,
                'billing_system_name' => $billing_system->name,
                'billing_system_id' => $billing_system->id,
                'billing_cycle_name' => $billing_cycle->name,
                'billing_cycle_id' => $billing_cycle->id,
                'payment_style_name' => $payment_style->name,
                'payment_style_id' => $payment_style->id,
                'payment_channel_name' => $payment_channel->name,
                'payment_channel_id' => $payment_channel->id,
                'active_cell' => $this->active_cell,
                'alternate_cell' => $this->alternate_cell,
                'email1' => $this->email1,
                'email2' => $this->email2,
                'address' => $this->address,
                'website' => $this->website,
                'sponsor_code' => $this->sponsor_code,
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        } else {
            return null;
        }
    }
}
