<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HospitalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'phone1'=>$this->phone1,
            'phone2'=>$this->phone2,
            'email1'=>$this->email1,
            'email2'=>$this->email2,
            'postal_address'=>$this->postal_address,
            'physical_address'=>$this->physical_address,
            'gps_location'=>$this->gps_location,
        ];
    }
}
