<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalExaminationTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $physical_examination_category=$this->physical_examination_category;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'physical_examination_category_id'=> $physical_examination_category->id??null,
            'physical_examination_category_name'=> $physical_examination_category->name??null,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
