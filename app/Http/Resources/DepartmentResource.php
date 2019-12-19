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
           $deputy_head=$this->deputy_head;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'head_name'=>$head->fullname??null,
                'head_id'=>$head->id??null,
                'deputy_head_name'=>$deputy_head->fullname??null,
                'deputy_head_id'=>$deputy_head->id??null,
                'status'=>$this->status,
            ];
        }

        else
           return NULL;
    }
}
