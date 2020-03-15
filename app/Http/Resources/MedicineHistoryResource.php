<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicineHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $medicine_history_category=$this->medicine_history_category;
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'medicine_history_category_id'=> $medicine_history_category->id,
            'medicine_history_category_name'=> $medicine_history_category->name,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at
        ];
    }
}
