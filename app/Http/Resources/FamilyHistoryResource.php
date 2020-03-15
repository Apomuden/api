<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FamilyHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $family_history_category=$this->family_history_category;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'family_history_category_id'=> $family_history_category->id,
            'family_history_category_name'=>$family_history_category->name,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
