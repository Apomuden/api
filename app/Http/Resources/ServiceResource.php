<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            $hospital_service=$this->hospital_service;
            $service_category=$this->service_category;
            $service_subcategory=$this->service_subcategory;
            $age_group=$this->age_group;
            return [
                'id'=>$this->id,
                'description'=>$this->display_name,
                'hospital_service_name'=>$hospital_service->name,
                'hospital_service_id'=>$hospital_service->id,
                'service_category_name'=>$service_category->name,
                'service_category_id'=>$service_category->id,
                'service_subcategory_name'=>$service_subcategory->name??null,
                'service_subcategory_id'=>$service_subcategory->id??null,
                'age_group_name'=>$age_group->name??null,
                'age_group_id'=>$age_group->id??null,
                'gender'=>$this->gender,
                'patient_status'=>$this->patient_status,
                'prepaid_amount'=>round($this->prepaid_amount,2),
                'postpaid_amount'=>round($this->postpaid_amount,2),
                'nhis_child_tariff_id'=>$this->nhis_child_tariff_id,
                'nhis_adult_tariff_id'=>$this->nhis_adult_tariff_id,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        else
           return NULL;
    }
}
