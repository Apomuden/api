<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IDTypeResource extends JsonResource
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
                'expires'=>boolval($this->expires),
                'status'=>$this->status,
            ];
        }

        else
           return NULL;
    }
}
