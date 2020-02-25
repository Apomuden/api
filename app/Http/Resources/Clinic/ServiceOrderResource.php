<?php

namespace App\Http\Resources\Clinic;

use App\Http\Helpers\DateHelper;
use Carbon\Traits\Date;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderResource extends JsonResource
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
        $folder = $patient->activefolder;
        $hospital_service=$this->hospital_service;
        $service_category=$this->service_category;
        $service_subcategory=$this->service_subcategory;
        $service=$this->service;
        $user=$this->user;
        $orderer=$this->orderer;
        $funding_type=$this->funding_type;
        $billing_system=$this->billing_system;
        $billing_cycle=$this->billing_cycle;
        $payment_style=$this->payment_style;
        $payment_channel=$this->payment_channel;
        $sponsorship_type=$this->sponsorship_type;
        $billing_sponsor=$this->billing_sponsor;
        $sponsorship_policy=$this->sponsorship_policy;
        $canceller=$this->canceller;
        $clinic_type = $this->clinic_type;
        $clinic = $this->clinic;
        return [
            'id'=>$this->id,
            'folder_no' => (($folder->folder_no ?? null) . ($patient->postfix ?? null)) ?? null,
            'patient_title' => $patient->title->name ?? null,
            'patient_name' => $patient->fullname ?? null,
            'gender' => $this->gender ?? null,
            'age' => $this->age ?? null,
            'patient_status'=>$this->patient_status ?? null,
            'clinic_type_name' => $clinic_type->name ?? null,
            'clinic_type_id' => $clinic_type->id ?? null,
            'clinic_name' => $clinic->name ?? null,
            'clinic_id' => $clinic->id ?? null,
            'hospital_service_name'=>$hospital_service->name,
            'hospital_service_id'=> $hospital_service->id,
            'service_category_name'=> $service_category->name,
            'service_category_id'=> $service_category->id,
            'service_subcategory_name'=> $service_subcategory->name,
            'service_subcategory_id'=> $service_subcategory->id,
            'service_name'=> $service->name,
            'service_id'=> $service->id,
            'service_fee'=>$this->service_fee,
            'service_quantity'=>$this->service_quantity,
            'service_total_amt'=>$this->service_total_amt,
            'service_date'=>(string) $this->service_date,
            'user_name'=>$user->name,
            'user_id'=>$user->id,
            'order_type'=>$this->order_type,
            'orderer_name'=>$orderer->name,
            'orderer_id'=>$orderer->id,
            'prepaid'=>boolval($this->prepaid),
            'paid_service_price'=>$this->paid_service_price,
            'paid_service_quantity'=>$this->paid_service_quantity,
            'paid_service_total_amt'=>$this->paid_service_total_amt,
            'funding_type_name'=>$funding_type->name,
            'funding_type_id'=>$funding_type->id,
            'billing_system_name'=>$billing_system->name,
            'billing_system_id'=>$billing_system->id,
            'billing_cycle_name'=>$billing_cycle->name,
            'billing_cycle_id'=>$billing_cycle->id,
            'payment_style_name'=>$payment_style->name,
            'payment_style_id'=>$payment_style->id,
            'payment_channel_name'=> $payment_channel->name,
            'payment_channel_id'=> $payment_channel->id,
            'insured'=>boolval($this->insured),
            'sponsorship_type_name'=>$sponsorship_type->name??null,
            'sponsorship_type_id'=>$sponsorship_type->id??null,
            'billing_sponsor_name'=>$billing_sponsor->name??null,
            'billing_sponsor_id'=>$billing_sponsor->id??null,
            'sponsorship_policy_name'=>$sponsorship_policy->name??null,
            'sponsorship_policy_id'=>$sponsorship_policy->id??null,
            'canceller_name'=> $canceller->name??null,
            'canceller_id'=> $canceller->id??null,
            'cancelled_date'=>(string) $this->cancelled_date,
            'status'=>$this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
