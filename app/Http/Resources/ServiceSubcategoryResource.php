<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceSubcategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
           $hospital_service=$this->hospital_service;
           $service_category=$this->service_category;

            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'hospital_service_name'=>$this->hospital_service->name??null,
                'hospital_service_id'=>$this->hospital_service->id??null,
                'service_category_name'=>$this->service_category->name??null,
                'service_category_id'=>$this->service_category->id??null,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];

    }
}
