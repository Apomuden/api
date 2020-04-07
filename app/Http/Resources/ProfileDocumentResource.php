<?php

namespace App\Http\Resources;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileDocumentResource extends JsonResource
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
            return [
                'id'=>$this->id,
                'name'=>$this->name,
                'staff_name'=>$staff->fullname,
                'user_id'=>$staff->id,
                'file'=>$this->file?\route('file.url',['users-files',$this->file]):null,
                'status'=>$this->status,
                'created_at'=>DateHelper::toDisplayDateTime($this->created_at),
                'updated_at'=>DateHelper::toDisplayDateTime($this->updated_at)
            ];
        }
        else
           return NULL;
    }
}
