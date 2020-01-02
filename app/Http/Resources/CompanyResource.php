<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id))
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'gps_location'=>$this->gps_location,
                'postal_address'=>$this->postal_address,
                'location_address'=>$this->location_address,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        else
           return NULL;
    }
}
