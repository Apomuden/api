<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class TitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(isset($this->id))
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'gender'=>$this->gender,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        else
           return NULL;
    }
}
