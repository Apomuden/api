<?php

namespace App\Http\Resources\Accounts;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class EreceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $services = [];
        foreach ($this->service_order as $service_order) {
            $services[]= [
                'id'=>$service_order->id,
                'description'=>$service_order->service->description??null,
                'service_fee'=>$service_order->service_fee??null,
                'service_quantity'=>$service_order->service_quantity??null,
                'service_total_amt'=>$service_order->service_total_amt??null,
                //'prepaid'=>boolval($service_order->prepaid),
                //'insured'=>boolval($service_order->insured),
                'service_bill'=>(!$service_order->prepaid && $service_order->insured) ? $service_order->service_total_amt : 0.00
            ];
        }
        return [
            'id'=>$this->id,
            'patient_id'=>$this->patient_id,
            'patient_status'=>$this->patient_status,
            'services'=>$services,
            'total_bill'=>$this->total_bill,
            'amount_paid'=>$this->amount_paid,
            'balance'=>$this->balance,
            'receipt_number'=>$this->receipt_number,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
        ];
    }
}
