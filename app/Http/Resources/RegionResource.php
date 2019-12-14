<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
                'name'=>$this->region_name,
                'country_id'=>$this->country_id,
                'status'=>$this->status,
                //'created_at'=>(String)$this->created_at,
                //'updated_at'=>(String)$this->updated_at 
            ];
        else 
           return NULL;
    }
}
