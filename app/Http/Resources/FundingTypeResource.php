<?php

namespace App\Http\Resources;

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
        if(isset($this->id)){
            $sponsorship_type=$this->sponsorship_type;
            $billing_system=$this->billing_system;
            $billing_cycle=$this->billing_cycle;
            $payment_style=$this->payment_style;
            $payment_channel=$this->payment_channel;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'sponsorship_type_name'=>$sponsorship_type->name,
                'sponsorship_type_id'=>$sponsorship_type->id,
                'billing_cycle_name'=>$billing_cycle->name,
                'billing_cycle_id'=>$billing_cycle->id,
                'payment_style_name'=>$payment_style->name,
                'payment_style_id'=>$payment_style->id,
                'payment_channel_name'=>$payment_channel->name,
                'payment_channel_id'=>$payment_channel->id,
                'billing_system_name'=>$billing_system->name,
                'billing_system_id'=>$billing_system->id,
                'description'=>$this->description,
                'status'=>$this->status,
            ];
        }

        else
           return NULL;
    }
}
