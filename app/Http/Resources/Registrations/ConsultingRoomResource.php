<?php

namespace App\Http\Resources\Registrations;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultingRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'description'=>$this->description,
            'gender'=>$this->gender,
            'status'=>$this->status,
            'created_at'=>(string) $this->created_at,
            'updated_at'=>(string) $this->updated_at,
        ];
    }
}
