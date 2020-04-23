<?php

namespace App\Http\Resources\Lab;

use App\Http\Helpers\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class LabSampleTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $pivot=$this->pivot??null;
        $data= [
            'id'=>$this->id,
            'name'=>$this->name,
            'prefix'=>$this->prefix??null
        ];

        if($pivot)
        $data['order']=$pivot->order;

        $data=$data+[
            'status' => $this->status,
            'created_at' => DateHelper::toDisplayDateTime($this->created_at),
            'updated_at' => DateHelper::toDisplayDateTime($this->updated_at)
        ];

        return $data;
    }
}
