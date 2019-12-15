<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgeGroupResource extends JsonResource
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
                'duration_type'=>$this->duration_type,
                'min_age'=>$this->min_age,
                'max_age'=>$this->max_age,
                'status'=>$this->status,
            ];
        }

        else
           return NULL;
    }
}
