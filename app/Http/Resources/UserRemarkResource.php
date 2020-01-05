<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRemarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user=$this->user;
        $remarker=$this->remarker;

        return [
            'id'=>$this->id,
            'type'=>$this->type,
            'user_id'=>$user->id??null,
            'user_name'=>$user->fullname??null,
            'remarker_id'=>$remarker->id,
            'remarker_name'=>$remarker->fullname,
            'remarks'=>$this->remarks,
            'status'=>$this->status,
            'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
            'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at),
        ];
    }
}
