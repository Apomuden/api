<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicePriceResource extends JsonResource
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
            $funding_type=$this->funding_type;
            $age_group=$this->age_group;
            return [
                'id'=>$this->id,
                'description'=>$this->display_name,
                'hospital_service_name'=>$hospital_service->name,
                'hospital_service_id'=>$hospital_service->id,
                'service_category_name'=>$service_category->name,
                'service_category_id'=>$service_category->id,
                'service_subcategory_name'=>$service_subcategory->name,
                'service_subcategory_id'=>$service_subcategory->id,
                'funding_type_name'=>$funding_type->name??null,
                'funding_type_id'=>$funding_type->id??null,
                'age_group_name'=>$age_group->name??null,
                'age_group_id'=>$age_group->id??null,
                'gender'=>$this->gender,
                'patient_status'=>$this->patient_status,
                'amount'=>$this->amount,
                'status'=>$this->status
            ];
        }
        else
           return NULL;
    }
}
