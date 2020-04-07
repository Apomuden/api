<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurgicalHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $surgical_history_category=$this->surgical_history_category;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'surgical_history_category_id'=> $surgical_history_category->id,
            'surgical_history_category_name'=>$surgical_history_category->name,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
