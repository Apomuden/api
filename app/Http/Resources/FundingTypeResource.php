<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class FundingTypeResource extends JsonResource
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
            $sponsorship_type = $this->sponsorship_type;
            $billing_system = $this->billing_system;
            $billing_cycle = $this->billing_cycle;
            $payment_style = $this->payment_style;
            $payment_channel = $this->payment_channel;
            return [
                'id' => $this->id,
                'name' => $this->name,
                'sponsorship_type_name' => $sponsorship_type->name ?? null,
                'sponsorship_type_id' => $sponsorship_type->id ?? null,
                'billing_cycle_name' => $billing_cycle->name ?? null,
                'billing_cycle_id' => $billing_cycle->id ?? null,
                'payment_style_name' => $payment_style->name ?? null,
                'payment_style_id' => $payment_style->id ?? null,
                'payment_channel_name' => $payment_channel->name ?? null,
                'payment_channel_id' => $payment_channel->id ?? null,
                'billing_system_name' => $billing_system->name ?? null,
                'billing_system_id' => $billing_system->id ?? null,
                'description' => $this->description,
                'status' => $this->status,
                'created_at' => DateHelper::toDisplayDateTime($this->created_at),
                'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
            ];
        } else {
            return null;
        }
    }
}
