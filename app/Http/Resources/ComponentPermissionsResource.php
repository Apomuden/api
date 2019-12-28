<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComponentPermissionsResource extends JsonResource
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
            $permissions=count($this->permissions)? PermissionResource::collection($this->permissions):[];
            //$permissions=$this->permissions;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'status'=>$this->status,
                'permissions'=>$permissions
            ];
        }
        else
           return NULL;
    }
}
