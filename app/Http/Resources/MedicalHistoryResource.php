<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $medical_history_category=$this->medical_history_category;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'medical_history_category_id'=> $medical_history_category->id,
            'medical_history_category_name'=> $medical_history_category->name,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
