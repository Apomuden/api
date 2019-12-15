<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
           $head=$this->head;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'head_name'=>$head->fullname??null,
                'head_id'=>$head->id??null,
                'status'=>$this->status,
            ];
        }

        else
           return NULL;
    }
}
