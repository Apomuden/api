<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $complaint_type=$this->complaint_type;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'complaint_type_id'=>$complaint_type->id,
            'complaint_type_name'=>$complaint_type->name,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
