<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffTypeResource extends JsonResource
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
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'validity_days'=>$this->validity_days,
                'status'=>$this->status,
            ];
        }
        else
           return NULL;
    }
}
