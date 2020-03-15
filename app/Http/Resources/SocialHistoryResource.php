<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $social_history_category=$this->social_history_category;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'social_history_category_id'=> $social_history_category->id,
            'social_history_category_name'=>$social_history_category->name,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
