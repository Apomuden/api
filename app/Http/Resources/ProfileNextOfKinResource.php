<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileNextOfKinResource extends JsonResource
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
            $staff=$this->user;
            $relationship=$this->relationship;
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'email'=>$this->email,
                'staff_name'=>$staff->fullname,
                'user_id'=>$staff->id,
                'relationship_name'=>$relationship->name,
                'relationship_id'=>$relationship->id,
                'address'=>$this->address??null,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        else
           return NULL;
    }
}
