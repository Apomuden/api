<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModulePermissionsResource extends JsonResource
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
            $components=new ComponentPermissionsCollection($this->components);
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'status'=>$this->status,
                'components'=>$components,
            ];
        }
        else
           return NULL;
    }
}
