<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfessionResource extends JsonResource
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
            $category=$this->staff_category;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'staff_category_name'=>$category->name,
                'staff_category_id'=>$category->id,
                'status'=>$this->status,

            ];
        }
        else
           return NULL;
    }
}
